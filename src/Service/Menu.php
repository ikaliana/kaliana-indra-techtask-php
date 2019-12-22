<?php

// app/src/Service/Menu.php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Model\Ingridient;
use App\Model\Recipe;

class Menu {
    
    private $ingridientsJsonPath;
    private $recipesJsonPath;
    private $serializer;
    private $ingridients = array();
    private $ingridientString = array();
    private $recipes = array();
     
    public function __construct(ParameterBagInterface $params)
    {
        $appPath = $params->get('kernel.project_dir');

        $this->ingridientsJsonPath = $appPath."\\src\\Repository\\ingridients.json";
        $this->recipesJsonPath = $appPath."\\src\\Repository\\recipes.json";

        $this->loadIngridients();
        $this->loadRecipes();
    }

    private function loadIngridients() {
        $json = file_get_contents($this->ingridientsJsonPath);
        $obj = json_decode($json);

        foreach($obj->ingredients as $ingridient) {
            $newIngridient = new Ingridient();
            $newIngridient->setTitle($ingridient->title);
            $newIngridient->setBestBefore($ingridient->{"best-before"});
            $newIngridient->setUseBy($ingridient->{"use-by"});

            $this->ingredients[] = $newIngridient;
            $this->ingridientString[] = $ingridient->title;
        }
    }

    private function loadRecipes() {
        $json = file_get_contents($this->recipesJsonPath);
        $obj = json_decode($json);

        foreach($obj->recipes as $recipe) {
            $newRecipe = new Recipe();
            $newRecipe->setTitle($recipe->title);
            $newRecipe->setIngridients($recipe->ingredients);

            $this->recipes[] = $newRecipe;
        }
    }

    private function getAvailableIngridients($todayDate, $fresh = true) {
        return array_filter($this->ingredients, function($item) use ($todayDate,$fresh) {
            if ($fresh) return $item->getBestBefore() >= $todayDate;
            else return $item->getUseBy() >= $todayDate; // && $item->getBestBefore() < $todayDate;
        });
    }

    public function getIngridientsAsString() {
        return join(", ",$this->ingridientString);
    }

    public function getRecipesAsString() {
        $value = "";
        foreach($this->recipes as $item) {
            $value .= $item->getTitle().":<br>".join(",",$item->getIngridients())."<br><br>";
        }

        return $value;
    }

    private function isValidDate($dateString) {
        return (bool)strtotime($dateString);
    }

    public function getTodayMenu($todayDate = "2019-03-10") {
        if (!$this->isValidDate($todayDate)) throw new \Exception("'".$todayDate."' is not a valid date format!");

        $freshIngridients = array_column($this->getAvailableIngridients($todayDate), 'title');
        $notSoFreshIngridients = array_column($this->getAvailableIngridients($todayDate,false), 'title');

        $freshMenu = array();
        $notSoFreshMenu = array();

        foreach($this->recipes as $recipe) {
            $currentIngridients = $recipe->getIngridients();
            $compare=array_intersect($currentIngridients,$freshIngridients);

            if (count($currentIngridients) == count($compare)) {
                $freshMenu[] = $recipe;
            }
            else {
                $compare=array_intersect($currentIngridients,$notSoFreshIngridients);
                if (count($currentIngridients) == count($compare))
                    $notSoFreshMenu[] = $recipe;
            }
        }

        return array_merge($freshMenu,$notSoFreshMenu);
    }

}
