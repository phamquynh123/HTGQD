<?php 
include_once('Core/Controller.php');
include_once('Helper/Fuzzy.php');

class HomeController extends Controller{
    protected $pulse;
    protected $symptom;
    protected $rules;

    public function __construct()
    {
        $this->pulse = $this->model("Pulse");
        $this->symptom = $this->model("Symptom");
        $this->rule = $this->model("Rule");
    }

    public function Home()
    {
        $pulse = $this->pulse->All();

        require_once('View/home.php');
    }

    public function Handle()
    {
        $data = $_POST;
        $listPulse = [];
        $jsonListPulse = '';
        $rule = $this->rule->All();
        foreach ($data as $key => $value) {
            array_push($listPulse, $key);
        }

        $fuzzy = new Fuzzy();
        $result = $fuzzy->handle($data, $this->rule, $listPulse);
        $symptom = $this->symptom->detail($result['symptomId']);
        $result['symptom'] = $symptom['name'];

        echo json_encode($result);
    }
}