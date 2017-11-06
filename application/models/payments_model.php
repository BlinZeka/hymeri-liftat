<?php

class Payments_Model extends  CI_Model{


	public function getPayments() {

		$query = $this->db->query('SELECT CONCAT(C.first_name," ", C.last_name) AS clientName ,  P.client_id as client_id, P.billed AS faturuar, P.paid AS paguar, P.date as date, P.`from` AS fromDate, P.`to` as toDate,
			f.name as flatName,f.number as flatNumber, e.name as entryName, b.name as building, comp.name as company
			FROM payments AS P
			INNER JOIN clients AS C ON C.id = P.client_id
			INNER JOIN flats f on f.id = C.flat_id
			INNER JOIN entries e on e.id = f.entry_id
			INNER JOIN buildings b on b.id = e.building_id
			INNER JOIN companies comp on comp.id = b.company_id
			where P.status = 1
			ORDER BY P.date DESC');
		
		return $query->result();
	}

	public function paymentRaportClient($clientId) {

		$query = $this->db->query('SELECT CONCAT(C.first_name,"", C.last_name) AS clientName ,  P.client_id as client_id, P.id as invoiceId ,P.billed AS faturuar, P.paid AS paguar, P.date as date, P.`from` AS fromDate, P.`to` as toDate, concat(adm.first_name, " " , adm.last_name) as created_by,
			f.name as flatName,f.number as flatNumber, e.name as entryName, b.name as building, comp.name as company, P.created_by as user_id
			FROM payments AS P
			INNER JOIN clients AS C ON C.id = P.client_id
			INNER JOIN flats f on f.id = C.flat_id
			INNER JOIN entries e on e.id = f.entry_id
			INNER JOIN buildings b on b.id = e.building_id
			INNER JOIN companies comp on comp.id = b.company_id
			INNER JOIN admin adm on adm.id = P.created_by
			where C.id= '.$clientId.' AND P.status = 1
			ORDER BY P.date DESC ');
		
		return $query->result();
	}

	public function paymentsPending(){
		$query = $this->db->query('SELECT c.id as client_id , comp.name as company, b.name as building,p.from as fromDate,  p.to as toDate,  c.first_name as first_name, ff.number as flatNo, ff.name as flatName,  c.last_name as last_name,  c.phone_1 as phone, c.email as email, e.name as entryName
			FROM clients c
			INNER JOIN flats f on f.id = c.flat_id 
			INNER JOIN entries e on e.id = f.entry_id 
			INNER JOIN buildings b on b.id =e.building_id
			INNER JOIN companies comp on comp.id = b.company_id
			INNER JOIN flats ff on ff.id = c.flat_id
			INNER JOIN payments p on p.client_id = c.id

			WHERE p.to  IN( SELECT max(pp.to) FROM payments pp WHERE pp.client_id = c.id ) 
			AND p.to < date_add(now(), interval 5 day)  AND  p.to > now()
			GROUP BY c.id
			ORDER BY p.`to` DESC');
		return $query->result();
	}

	public function addPayment($arr){

		// $from = $this->input->post('from');
		// $fromconvert = str_replace('/', '-', $from);
		// $from_seperate = explode("-",$fromconvert);
		// $fromOK = $from_seperate['2'] . '-' .$from_seperate['0'] . '-' . $from_seperate['1'];
		// // echo $fromOK . '<BR>';
		// $to = $this->input->post('to');
		// $toconvert = str_replace('/', '-', $to);
		// $to_seperate = explode("-",$toconvert);
		// $toOK = $to_seperate['2'] . '-' .$to_seperate['0'] . '-' . $to_seperate['1'];
		// echo $toOK;

		echo "month " + $this->input->post('month');

		$arr = array(      
			'client_id' => $this->input->post('client_id') , 
			"billed"=>'0', 
			"paid"=>$this->input->post('paid'), 
			"date"=>date("Y-m-d"),
			"from"=>$this->input->post('from'),
			"to"=>$this->input->post('to'),
			"month"=>$this->input->post('month'),
			"year"=>$this->input->post('year'),
			"created_by"=>$arr['created_by'],
			"valute"=>$this->input->post('valute'),
			"create_date"=>'',
			"updated_by"=>'1',
			"update_date"=>'',
			"update_no" =>'0',
			"status" =>'1'
			);

		$flag =  $this->db->insert('payments', $arr);
		
		if ($flag) {
			
			$now = time();
			$toDate = strtotime($this->input->post('to'));

			if ($toDate >= $now) {
				$array = array("status" =>1);
				$this->db->where('card_id IN(select id from cards where client_id = ' . $this->input->post('client_id'). ' )' );
				return $this->db->update('elevators_cards', $array);
			}else{
				echo "date less than today";
			}
			
		} else {
			"Pagesa nuk u kry me sukses";
		}
		

	}
	

	
	public function editData($arr) {
		$id = $arr['id'];
		unset($arr['id']);
		
		$this->db->where('id', $id);
		$arr['update_date'] = time();
		return $this->db->update('companies', $arr);
	}
	
	public function disableData($id) {                                                
		$this->db->where('id', $id);
		return $this->db->delete('companies');
	}
	
	public function getCities() {
		return $this->db->query('SELECT * FROM `cities`')->result_array();
	}

	public function getPayementsByUser($id,$start,$end,$valute){
		return $this->db->query("SELECT b.name as building, e.name as entry , f.number as flat, concat(c.first_name, ' ',c.last_name ) as name, p.`from` as 'from',  p.valute as valute, p.date as 'date',  p.`to` as 'to', p.paid as paid, p.status as status, p.note as note from payments p
			INNER JOIN clients c on c.id = p.client_id
			INNER JOIN flats f on f.id = c.flat_id
			inner join entries e on e.id = f.entry_id
			inner join buildings b on b.id = e.building_id
			where p.status = 1 AND p.created_by  = ".$id." AND p.valute = '".$valute."' AND p.date >= '".$start."' AND p.date <='".$end."' and paid > 0
			")->result_array();
	}

	public function getCardsByUser($id,$start,$end){
		return $this->db->query("SELECT concat(c.first_name, ' ', c.last_name)  as name, c.last_name as lname, card.card_no as card_no, card.site_code as site_code, card.site_no as site_no, card.floors as floors,  FROM_UNIXTIME(card.create_date)  as date from cards card
			INNER JOIN clients c on c.id = card.client_id
			where card.created_by  = ".$id." AND card.create_date >= ". strtotime($start) ." AND card.create_date <=". strtotime($end) ."
			")->result_array();
	}



	public function deletePayment($year,$month,$user_id,$note = false, $admin_id) {
		
		
		$this->db->where('year', $year);
		$this->db->where('month', $month);
		$this->db->where('client_id', $user_id);
		$arr['note'] = $note;
		$arr['update_date'] = date('Y-m-d', time());
		$arr['updated_by'] = $admin_id;
		$arr['status'] = 2;
		
		//echo date('d-m-Y', time()); 
		//print_r($this->db->update('payments', $arr));
		return $this->db->update('payments', $arr);
	}
	
}
?>