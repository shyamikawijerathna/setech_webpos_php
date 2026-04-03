
    <nav class="navbar navbar-expand-lg navbar-light  sticky-top shadow-sm" style="background-color: #1fd4cb;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><h2><strong>SE TECH.LK</strong></h2></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

           


            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="portfolio.php">Portfolio</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
            </div>
        </div>
        
    </nav>

    <form class="ebay-search-wrapper">
                <div class="category-select" style="margin-left: 20px;background-color: #f8f9fa; border-radius: 5px; padding: 2px;">
                    <select name="category" id="navbarCategorySelect" onchange="handleNavbarCategoryChange(this.value)">
                        <option value="0" style="border: none; background: #3f8cda; padding: 5px;">All Categories</option>
                        <option value="1">Phone Spare Parts</option>
                        <option value="2">Phone Accessories</option>
                        <option value="3">Used Phones</option>
                        <option value="4">Desktop PC Accessories</option>
                        <option value="5">Desktop PC Used</option>
                        <option value="6">Used Laptops</option>
                        <option value="7">Laptop Accessories</option>
                        <option value="8">Laptop Spare Parts-Used</option>
                        <option value="9">Laptop Spare Parts-New</option>
                    </select>
                </div>

                <script>
                    function handleNavbarCategoryChange(value) {
                        if (value === '1') {
                            window.location.href = 'phone_spare_parts.php';
                        }
                       
                        else if (value === '2') { 
                            window.location.href = 'phone_accessories.php'; 
                        }

                        else if (value === '3') { 
                            window.location.href = 'used_phones.php'; 
                        }
                        else if (value === '4') { 
                            window.location.href = 'desktop_pc_accessories.php'; 
                        }
                        else if (value === '5') { 
                            window.location.href = 'desktop_pc_used.php'; 
                        }
                        else if (value === '6') { 
                            window.location.href = 'laptop_used.php'; 
                        }

                        else if (value === '7') { 
                            window.location.href = 'laptop_accessories.php'; 
                        }
                        else if (value === '8') { 
                            window.location.href = 'laptop_spare_parts_used.php'; 
                        }
                        else if (value === '9') { 
                            window.location.href = 'laptop_spare_parts_new.php'; 
                        }
                        else {
                            window.location.href = 'index.php'; 
                        }
                    }
                </script>

                <div class="search-input-group">
                    <svg class="search-icon"  width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" placeholder="Search for anything" aria-label="Search">
                </div>

                <button type="submit" class="search-button">Search</button>
            </form>