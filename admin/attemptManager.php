<?php
foreach (glob("../_classes/*.php") as $filename) {
	require "$filename";
}
$attempt = new attempt;

if (isset($_GET['create']) && isset($_GET['user_id']) && isset($_GET['score'])) {
	$attempt -> set_user_id($_GET['user_id']);
	$attempt -> set_score($_GET['score']);
	$attempt -> saveToDB();

}
if (isset($_GET['delete']) && isset($_GET['attempt_id'])) {
	$attempt -> getFromDB($_GET['attempt_id']);
	$attempt -> deleteFromDB();
}
if (isset($_GET['edit']) && isset($_GET['attempt_id']) && isset($_GET['user_id']) && isset($_GET['score'])) {
	$attempt -> getFromDB($_GET['attempt']);
	$attempt -> set_score($_GET['score']);
	$attempt -> set_user_id($_GET['user_id']);
	$attempt -> updateInDB();
}
?>