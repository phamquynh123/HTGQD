<?php

class Fuzzy {
	// Ví dụ
	public function vidu() {
		$hoihot = 0.8; // xung hời hợt
		$cham = 0.6; // xung chậm 
		$wsymptompulse1 = 1; // tầm quan trọng của triệu chứng heartwind (xung hời hợt)
		$wsymptompulse2 = 1; // tầm quan trọng  của triệu chứng heartwind (xung chậm)
		$wsymptompulse3 = 1; // tầm quan trọng của triệu chứng primary Allergy(xung hời hợt)
		$wsymptompulse4 = 1; // tầm quan trọng  của triệu chứng primary Allergy (xung chậm)
		// LUẬT 3
		$wpulsesymptom1 = 0.4; // khả năng bệnh xung hời hợt bênh heartwind
		//LUẬT 4
		$wpulsesymptom2 = 0.2; // khả năng bệnh xung hời hợt bênh heartwind
		//LUÂT 6
		$wpulsesymptom3 = 0.6; // khả năng bệnh xung hời hợt, xung chậm bênh primary Allergy

		// tính khả năng mắc bệnh heatwind
		//Áp dụng luật 3 và luật 4
		$heartwind = max(min(min($wsymptompulse1, $hoihot), $wpulsesymptom1), min(min($wsymptompulse2, $cham), $wpulsesymptom2));
		//Áp dụng luật 6 - do cái này là cả 2 xung
		$allery = min(min(1,0.8), min(1,0.6), 0.6);

		if ($heartwind > $allery) {
			return "heartwind : " . $heartwind;
		} else if($heartwind < $allery) {
			return "allery : " . $allery;
		} else {
			return "heartwind : 50% , allery : 50%";
		}
	}

	public function handle($data, $ruleModel, $listPulse)
	{
		$symptom = array(
			'weight' => 0,
			'symptomId' => 0
		);

		//Single
		for ($i=0; $i < count($listPulse); $i++) {
			$rule = $ruleModel->where($listPulse[$i]);
			if (isset($rule)) {
				$symptom = $this->singlefuzzy($symptom, $listPulse[$i], $rule, $data);
			}
		}

		// Multiple - 2 nếu 3 xung
		$countListPulse = count($listPulse);
		$multiListPulse = [];
		if ($countListPulse == 3) {// [1,2,3]
            array_push($multiListPulse, array_slice($listPulse, 0, 2)); //[1,2]
            array_push($multiListPulse, array_slice($listPulse, 1, 2)); //[2,3]
            array_push($multiListPulse, array($listPulse[2], $listPulse[0])); //[3,1]
            for ($i=0; $i < count($multiListPulse); $i++) { 
            	$rule = $ruleModel->where('"[' . implode(',', $multiListPulse[$i]) . ']"');
            	if (isset($rule)) {
            		$symptom = $this->multifuzzy($symptom, $multiListPulse[$i], $rule, $data);
            	}
            }
        }

        // Multiple - 3 / 2
        $rule = $ruleModel->where('"[' . implode(',',$listPulse) . ']"');
        if (isset($rule)) {
        	$symptom = $this->multifuzzy($symptom, $listPulse, $rule, $data);
        }

        $symptom['weight'] = $symptom['weight'] * 100;
        return $symptom;
    }

    public function multifuzzy($symptom, $listPulse, $rule, $data)
    {
    	$wsymptompulse = explode(",", substr(substr($rule['wsymptompulse'], 1), 0, -1));
    	for ($j=0; $j < count($listPulse); $j++) {
    		$rule['wsymptompulse'] = $wsymptompulse[$j];
    		$symptom = $this->singlefuzzy($symptom, $listPulse[$j], $rule, $data);
    	}

    	return $symptom;
    }

    public function singlefuzzy($symptom, $pulse, $rule, $data)
    {
    	$chiso = min(min($rule['wsymptompulse'], $data[$pulse]), $rule['wpulsesymptom']);
    	if ($symptom['weight'] < $chiso) {
    		$symptom['weight'] = $chiso;
    		$symptom['symptomId'] = $rule['symptomId'];
    	}

    	return $symptom;
    }
}


// Theem id benehj nhan
