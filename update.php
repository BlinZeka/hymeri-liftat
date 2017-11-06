<?php 
	$link = mysql_connect('localhost', 'itrendin', 'itrendin.123') or die (mysql_error());
mysql_select_db('elevator_new');


//mysql_query("UPDATE elevators_cards ec SET ec.status = 0 WHERE ec.card_id IN( SELECT ca.id FROM cards ca WHERE ca.client_id IN (SELECT p.client_id FROM payments p WHERE p.`to` IN (SELECT max(pp.to) FROM payments pp WHERE pp.client_id = p.client_id) AND p.`to` < NOW() AND p.`to` > 0))");

// mysql_query("UPDATE elevators_cards ec SET ec.status = 0 WHERE ec.card_id IN (SELECT ca.id FROM cards ca WHERE ca.client_id IN (SELECT p.client_id FROM payments p WHERE p.`to` IN (SELECT max(pp.to) FROM payments pp WHERE pp.client_id = p.client_id) AND p.`to` < NOW() AND p.`to` > 0))");

mysql_query("UPDATE elevators_cards ec SET ec.status = 0 WHERE ec.card_id IN (SELECT ca.id FROM cards ca WHERE ca.client_id IN (SELECT p.client_id FROM payments p WHERE p.`to` IN (SELECT MAX(pp.to) FROM payments pp WHERE pp.client_id = p.client_id AND pp.status = 1) AND p.`to` < NOW() AND p.`to` > 0 ))");

//mysql_query("UPDATE elevators_cards ec SET ec.status = 0 WHERE ec.card_id IN (SELECT ca.id FROM cards ca WHERE ca.client_id IN (SELECT p.client_id FROM payments p where p.`status` = 1 and p.`to` > 0 group by p.client_id having MAX(p.`to`) < NOW()))");

echo "Finished";

?>