<?php require "_header.view.php"; ?>

<?php require "_navbar.view.php"; ?>

<?php require "_sidebar.view.php"; ?>

                <?php if (\App\App\Models\Gate::hasRole('admin') || \App\App\Models\Gate::hasRole('opettaja')):?>
                    <li><a href="/session-report" class="button">Sessioraportit</a> </li>
                    <li><a href="/tasklistsession-report" class="button">Tehtävälistan<br>suoritusaikaraportit</a> </li>
                <?php endif;?>
            </ul>
        </nav>
    </div>
<?php require 'message.view.php'; ?>

<?php require "_footer.view.php"; ?>