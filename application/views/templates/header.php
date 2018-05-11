<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url() ?>">
                    <?= $this->config->item('app_name') ?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <?php
                            if (!isset($this->session->username))
                            {
                            	echo "<li><a class=\"nav-link\" href=\"" . base_url() . "login\">Login</a></li>";
                            	echo "<li><a class=\"nav-link\" href=\"" . base_url() . "register\">Register</a></li>";
                            }
                        	else
                        	{
                        		echo
                        		"
                        		<li class=\"nav-item dropdown\">
	                                <a class=\"nav-link dropdown-toggle\" href=\"#\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
	                                    " . $this->session->first_name . " " . $this->session->last_name . " <span class=\"caret\"></span>
	                                </a>
	                                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
	                                    <a class=\"dropdown-item\" href=\"" . base_url() . "settings\">Settings</a>
	                                    <a class=\"dropdown-item\" href=\"" . base_url() . "logout\"
	                                       onclick=\"event.preventDefault();
	                                                 document.getElementById('logout-form').submit();\">
	                                        Logout
	                                    </a>

	                                    <form id=\"logout-form\" action=\"" . base_url() . "logout\" method=\"GET\" style=\"display: none;\">
	                                    </form>
	                                </div>
	                            </li>
                        		";
                        	}
                        ?>
                    </ul>
                </div>
            </div>
        </nav>