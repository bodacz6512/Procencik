<div class="wrapper">
        <!-- Sidebar Holder -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin</h3>
            </div>

            <ul class="list-unstyled components">
                <p></p>
                <li <?php if(basename($_SERVER["SCRIPT_FILENAME"])  == "slowa.php") echo 'class="active"'; ?>>
                    <a href="slowa.php">Kategorie</a>
                </li>
				<li <?php if(basename($_SERVER["SCRIPT_FILENAME"])  == "generuj.php") echo 'class="active"'; ?>>
                    <a href="generuj.php">Odśwież kategorię</a>
                </li>
            </ul>

        </nav>