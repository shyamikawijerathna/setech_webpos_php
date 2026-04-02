<nav class="custom-navbar">
  <div class="nav-container">
    
    <a class="nav-brand" href="index.php">
        <i class="fa-solid fa-cash-register brand-icon"></i>
        <div class="brand-text">
            <span class="brand-name">Company Name Here</span>
            <span class="brand-sub">Address or Town</span>
        </div>
    </a>
    
    <div class="nav-menu">
      <ul class="nav-links">
        <li>
          <a class="nav-item active" href="index.php">
            <i class="fa-solid fa-house"></i> Home
          </a>
        </li>

        <?php if(isset($_SESSION['loggedIn'])) : ?>
            <li>
              <span class="user-profile">
                <i class="fa-solid fa-circle-user"></i> 
                <?= $_SESSION['loggedInUser']['name']; ?>
              </span>
            </li>
            <li>
              <a class="btn-logout" href="logout.php">
                 <i class="fa-solid fa-right-from-bracket"></i> Logout
              </a>
            </li>
        <?php else : ?>
            <li>
                <a class="nav-item" href="login.php">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>
            </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>


<style>
/* Custom Navbar Container */
.custom-navbar {
    background: linear-gradient(90deg, #1e3a8a 0%, #4338ca 100%);
    padding: 12px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    color: white;
}

.nav-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Brand Section */
.nav-brand {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: white;
}

.brand-icon {
    font-size: 1.5rem;
    margin-right: 12px;
}

.brand-text {
    display: flex;
    flex-direction: column;
}

.brand-name {
    font-weight: 700;
    font-size: 1.1rem;
    letter-spacing: 0.5px;
}

.brand-sub {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.6);
    font-weight: 300;
}

/* Links List */
.nav-links {
    list-style: none;
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
}

.nav-links li {
    margin-left: 25px;
}

.nav-item {
    text-decoration: none;
    color: rgba(255, 255, 255, 0.85);
    font-weight: 500;
    font-size: 0.95rem;
    transition: color 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-item:hover, .nav-item.active {
    color: white;
}

/* User Profile Capsule */
.user-profile {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Logout Button */
.btn-logout {
    background: #ef4444;
    color: white;
    text-decoration: none;
    padding: 6px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 700;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-logout:hover {
    background: #dc2626;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    transform: translateY(-1px);
}

/* Responsive Design (Mobile) */
@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        gap: 15px;
    }
    .nav-links li {
        margin: 0 10px;
    }
}

</style>