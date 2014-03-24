<?php
@session_start();

if(isset($_GET['n'])&&isset($_GET['t'])){
	$_SESSION['fIESnum'] = $_GET['n'];
	$_SESSION['fType'] = $_GET['t'];?>
	<select class="filterSearch" name="fType" id="fTypeSelect" onchange="filter(document.getElementById('fIESnumSelect').value,this.value)">
		<option value="ies_num" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="ies_num"){echo "selected";}}else{echo "selected";}?>>IES Number</option>
		<option value="name" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="name"){echo "selected";}}?>>Name</option>
		<option value="customer" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="customer"){echo "selected";}}?>>Customer</option>
		<option value="engineer" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="engineer"){echo "selected";}}?>>Engineer</option>
		<option value="notes" <?php if(isset($_SESSION['fIESnum'])){if($_SESSION['fType']=="notes"){echo "selected";}}?>>Notes</option>
	</select>
	<input type="text" name="IESnum"  class="filterSearch" id="fIESnumSelect" value="<?php if(isset($_SESSION['fIESnum'])){echo $_SESSION['fIESnum'];}?>" onkeyup="filter(this.value,document.getElementById('fTypeSelect').value)" autocomplete="off"/>
<?php } ?>
