 <?php
    if (is_array($exchangeRate)) {
        foreach ($exchangeRate as $key => $value) {
?>
            <div class="row-tr">
                 <div class="row-td"><span> <?php echo number_format($value["money"], 0) ?>VNĐ</span></div>
                 <div class="row-td">Kim Cương x <?php echo number_format($value["knb"], 0) . " " . $value["unit"] ?></div>
            
			</div>

<?php
        }
    }
?>
		
