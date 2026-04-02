<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.php">MDM Restaurent</a>
    
    
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
        <i class="fas fa-bars"></i>
    </button>
    
    <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        </div>
    
        
   

    <!-- Date and time -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 align-items-center">
        
       

        <li class="nav-item ">
            <span class="nav-link fw-bold me-3" id="liveClock" style="color: #ffff;font-size: 14px; "></span>
        </li>
        
    <!-- Drop down list -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i>
                <?= $_SESSION['loggedInUser']['name'] ?? 'User'; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <!--  <li><a class="dropdown-item" href="#!">Settings</a></li> 
                <li><a class="dropdown-item" href="#!">Activity Log</a></li> 
                <li><hr class="dropdown-divider" /></li> -->
                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>

<script>
    function updateClock() {
        const now = new Date();
        const options = { 
            day: '2-digit', month: 'short', year: 'numeric',
            hour: '2-digit', minute: '2-digit', second: '2-digit', 
            hour12: true 
        };
        document.getElementById('liveClock').innerHTML = now.toLocaleString('en-US', options);
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>