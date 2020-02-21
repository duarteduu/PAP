<div id="menu">
    <ul>
        <?php
        if ($_SESSION['isAdmin']){
            echo '<li><a href="users.php"><i class="fas fa-users"></i> Utilizadores</a></li>';
        }

        ?>
        <li><a href="orders.php"><i class="fas fa-box-open"></i> Encomendas</a></li>
		<?php
		if ($_SESSION['isAdmin']){
			echo '<li><a href="providers.php"><i class="fas fa-hands-helping"></i> Fornecedores</a></li>';
		}
		?>
        <li><a href="crms.php"><i class="fas fa-user-md"></i> CRMS</a></li>
        <li><a href="logout.php" class="right red"><i class="fas fa-sign-out-alt"></i> Sair</a ></li>
        <li><a href="settings.php" class="right"><i class="fas fa-cogs"></i> <?php echo $user_row['username']; ?></b> </a> </li>
    </ul>
</div>
