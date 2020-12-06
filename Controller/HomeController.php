<?php 
include_once('Core/Controller.php');
include_once('Helper/Fuzzy.php');

class HomeController extends Controller{
    protected $pulse;
    protected $symptom;
    protected $rules;
    protected $user;

    public function __construct()
    {
        $this->pulse = $this->model("Pulse");
        $this->symptom = $this->model("Symptom");
        $this->rule = $this->model("Rule");
        $this->user = $this->model("User");
    }

    public function welcome()
    {
        require_once('View/welcome.php');
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
        // $jsonListPulse = '';
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

    public function search()
    {
        $data = $_POST;
        $infor = $this->user->find( 'cmnd', $data['cmnd']);
        if($infor == []) {
            echo json_encode($infor);     
        } else {
            echo json_encode($infor[0]);
        }
    }

    public function add()
    {
        $data = $_POST;
        // print_r($data); die;

        if($data['id'] == '') {
            $result = $this->user->insert($data);
        } else {
            $result = $this->user->update($data);
        }
        if($result == 1) {
                $result = $data;
            }
        $pulse = $this->pulse->All();
        require_once('View/home.php');
    }

}