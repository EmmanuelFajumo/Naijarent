<?php
session_start();
require_once "process_pages/classes/Site.php";
require_once "process_pages/classes/Tenant.php";

$prop = new Site();
$user = new Tenant();

if(isset($_SESSION['useronline'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
}
if(isset($_SESSION['agent_online'])){
    $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Agents - NaijaRent</title>
    <meta name="description" content="Discover and browse verified real estate agents in Lagos on NaijaRent" />
    <meta name="author" content="Emmanuel Fajumo" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">

    <style>
        /* Headings Font Override */
        h1, h2, h3, h4, h5, h6 {
            font-family: "Voltaire", sans-serif;
        }
        
        body {
            font-family: "Inter", sans-serif;
            background-color: #f8f9fa;
        }

        /* Page Header Custom Styling */
        .agent-header-section {
            background: linear-gradient(135deg, #14213D, #1E3888);
            padding: 70px 0;
            color: #ffffff;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
        }

        /* Responsive Filter Bar styling */
        .filter-bar {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef2f7;
            margin-top: -40px;
            position: relative;
            z-index: 20;
            padding: 24px;
        }

        /* Premium Agent Card design */
        .agent-card {
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            border: 1px solid #f0f0f0;
            background-color: #ffffff;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* Gold "Top Rated" Ribbon style */
        .top-rated-ribbon {
            position: absolute;
            top: 18px;
            right: -32px;
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #1a1a1a;
            font-weight: 800;
            font-size: 0.65rem;
            padding: 5px 32px;
            transform: rotate(45deg);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            z-index: 10;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }

        /* Agent Profile Image wrapper */
        .agent-img-wrapper {
            width: 105px;
            height: 105px;
            margin: 10px auto 18px auto;
            position: relative;
        }

        .agent-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f0f2f5;
            transition: border-color 0.3s ease;
        }

        .agent-card:hover .agent-img {
            border-color: #1E3888;
        }

        /* Rating Stars Color */
        .star-rating i {
            color: #FFD700;
        }

        /* Consistent Platform Brand Colors */
        .text-primary-deep {
            color: #1E3888;
        }

        .btn-primary {
            background-color: #1E3888 !important;
            border-color: #1E3888 !important;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #14213D !important;
            border-color: #14213D !important;
        }

        .btn-outline-primary {
            color: #1E3888 !important;
            border-color: #1E3888 !important;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            color: #ffffff !important;
            background-color: #1E3888 !important;
        }

        /* Empty State */
        .empty-state-icon {
            font-size: 4.5rem;
            color: #cbd5e1;
        }

        /* Card Specialization Meta block */
        .spec-meta-block {
            border-top: 1px solid #f1f3f5;
            border-bottom: 1px solid #f1f3f5;
            padding: 12px 0;
            margin: 12px 0;
            text-align: left;
        }

        /* Ellipsis truncation for Bio */
        .agent-bio-trunc {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.5;
            min-height: 45px;
        }

        /* Form elements rounded-pill */
        .form-select, .form-control {
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            border: 1px solid #ced4da;
        }

        .form-select:focus, .form-control:focus {
            border-color: #1E3888;
            box-shadow: 0 0 0 0.25rem rgba(30, 56, 136, 0.25);
        }

        /* Pagination custom page-item styling */
        .page-item.active .page-link {
            background-color: #1E3888 !important;
            border-color: #1E3888 !important;
        }
        .page-link {
            color: #1E3888;
            border-radius: 6px;
            margin: 0 3px;
        }
        .page-link:hover {
            color: #14213D;
            background-color: #eef2f7;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <?php include 'nav.php'; ?>

    <!-- Page Header Section -->
    <div class="container-fluid agent-header-section text-center animate__animated animate__fadeIn">
        <div class="container">
            <h1 class="display-4 fw-bold">Find a Trusted Agent in Lagos</h1>
            <p class="lead mb-4 opacity-90 mx-auto" style="max-width: 750px;">All agents on NaijaRent are identity-verified. Browse profiles, read real reviews, and connect directly.</p>
            <span class="badge text-bg-light px-4 py-2 rounded-pill fs-6 fw-semibold shadow-sm" id="agent-count-badge">1,340 verified agents</span>
        </div>
    </div>

    <!-- Main Container -->
    <div class="container pb-5 mb-5">
        
        <!-- Search & Filter Bar -->
        <div class="filter-bar animate__animated animate__fadeInUp">
            <form id="filterForm" onsubmit="event.preventDefault(); applyFilters();">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Search by agent name or agency...">
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-lg-2.5">
                        <label class="form-label small fw-semibold text-muted mb-1">LGA</label>
                        <select id="lgaSelect" class="form-select">
                            <option value="">All LGAs</option>
                            <option value="Lekki">Lekki</option>
                            <option value="Ikeja">Ikeja</option>
                            <option value="Yaba">Yaba</option>
                            <option value="Surulere">Surulere</option>
                            <option value="Ajah">Ajah</option>
                            <option value="Gbagada">Gbagada</option>
                            <option value="Maryland">Maryland</option>
                            <option value="Ikoyi">Ikoyi</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 col-lg-2.5">
                        <label class="form-label small fw-semibold text-muted mb-1">Property Type</label>
                        <select id="typeSelect" class="form-select">
                            <option value="">All Types</option>
                            <option value="Flat">Flat</option>
                            <option value="Duplex">Duplex</option>
                            <option value="Self-contained">Self-contained</option>
                            <option value="Mini Flat">Mini Flat</option>
                            <option value="Bungalow">Bungalow</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 col-lg-2.5">
                        <label class="form-label small fw-semibold text-muted mb-1">Sort By</label>
                        <select id="sortSelect" class="form-select">
                            <option value="listings">Most Listings</option>
                            <option value="rating">Highest Rated</option>
                            <option value="newest">Newest</option>
                        </select>
                    </div>
                    
                    <div class="col-md-12 col-lg-1.5 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 py-2.5 fw-semibold"><i class="fa-solid fa-sliders me-1"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Agent Cards Grid -->
        <div class="row g-4 mt-3" id="agentGrid">
            <!-- Dynamically populated by JS -->
        </div>

        <!-- Empty State (hidden by default) -->
        <div id="emptyState" class="text-center py-5 my-5 d-none animate__animated animate__fadeIn">
            <div class="mb-3">
                <i class="fa-regular fa-face-frown-open empty-state-icon"></i>
            </div>
            <h3 class="fw-bold" style="font-family: 'Voltaire', sans-serif; font-size: 2.2rem;">No Agents Match Your Search</h3>
            <p class="text-muted mb-4 max-width-500 mx-auto">We couldn't find any registered agents matching your filters. Try clearing your search query or selecting a different LGA.</p>
            <button onclick="clearFilters()" class="btn btn-primary px-5 py-2.5 rounded-pill fw-semibold shadow-sm text-light">Clear All Filters</button>
        </div>

        <!-- Pagination Section -->
        <div id="paginationSection" class="mt-5 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <div class="text-muted small" id="paginationInfo">
                <!-- Rendered dynamically -->
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination mb-0" id="paginationLinks">
                    <!-- Rendered dynamically -->
                </ul>
            </nav>
        </div>

    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mock database of Lagos agents
        const agentsData = [
            {
                id: 1,
                name: "Chidi Obi",
                agency: "Obi & Co. Properties",
                rating: 4.8,
                reviewsCount: 142,
                listingsCount: 28,
                lgas: ["Lekki", "Ikoyi"],
                propertyTypes: ["Flat", "Duplex"],
                bio: "Specializes in luxury residential rentals in Lekki and Ikoyi with over 8 years of experience.",
                image: "media/q.png",
                dateAdded: "2025-01-10"
            },
            {
                id: 2,
                name: "Funmi Adebayo",
                agency: "Adebayo Realty Group",
                rating: 4.9,
                reviewsCount: 96,
                listingsCount: 19,
                lgas: ["Ikeja", "Maryland", "Gbagada"],
                propertyTypes: ["Flat", "Mini Flat", "Self-contained"],
                bio: "Helping mainland tenants discover affordable, modern mini-flats and self-contain units.",
                image: "media/q.png",
                dateAdded: "2025-02-15"
            },
            {
                id: 3,
                name: "Emeka Okafor",
                agency: "Okafor Associates",
                rating: 4.2,
                reviewsCount: 54,
                listingsCount: 12,
                lgas: ["Yaba", "Surulere"],
                propertyTypes: ["Flat", "Self-contained", "Mini Flat"],
                bio: "Dedicated to student housing solutions and rental homes near Unilag and Yabatech.",
                image: "media/q.png",
                dateAdded: "2025-03-20"
            },
            {
                id: 4,
                name: "Tunde Bakare",
                agency: "Bakare Homes & Lands",
                rating: 4.7,
                reviewsCount: 110,
                listingsCount: 24,
                lgas: ["Ajah", "Lekki"],
                propertyTypes: ["Duplex", "Bungalow"],
                bio: "Experienced in family bungalows and high-end residential listings along the Lekki corridor.",
                image: "media/q.png",
                dateAdded: "2025-04-05"
            },
            {
                id: 5,
                name: "Yejide Balogun",
                agency: "Balogun Real Estate",
                rating: 4.6,
                reviewsCount: 73,
                listingsCount: 15,
                lgas: ["Gbagada", "Maryland"],
                propertyTypes: ["Flat", "Mini Flat"],
                bio: "Providing seamless leasing services focused on cozy family apartments in Gbagada.",
                image: "media/q.png",
                dateAdded: "2025-05-12"
            },
            {
                id: 6,
                name: "Mustapha Yusuf",
                agency: "Yusuf & Sons Properties",
                rating: 4.4,
                reviewsCount: 38,
                listingsCount: 8,
                lgas: ["Surulere", "Yaba"],
                propertyTypes: ["Flat", "Bungalow", "Self-contained"],
                bio: "Client-focused leasing representative specializing in mainland flats and self-contained homes.",
                image: "media/q.png",
                dateAdded: "2025-06-01"
            },
            {
                id: 7,
                name: "Blessing Okon",
                agency: "Okon & Partners Ltd.",
                rating: 4.5,
                reviewsCount: 81,
                listingsCount: 17,
                lgas: ["Lekki", "Ajah", "Maryland"],
                propertyTypes: ["Flat", "Self-contained", "Duplex"],
                bio: "Passionate about finding quality family apartments and flats with seamless rental steps.",
                image: "media/q.png",
                dateAdded: "2025-06-18"
            },
            {
                id: 8,
                name: "Amina Bello",
                agency: "Bello Elite Properties",
                rating: 4.9,
                reviewsCount: 65,
                listingsCount: 21,
                lgas: ["Ikoyi", "Ikeja"],
                propertyTypes: ["Duplex", "Flat", "Bungalow"],
                bio: "Delivering executive-level service in luxury property acquisitions and rentals across Lagos.",
                image: "media/q.png",
                dateAdded: "2025-07-02"
            }
        ];

        let filteredAgents = [...agentsData];
        const itemsPerPage = 6;
        let currentPage = 1;

        function applyFilters() {
            const searchVal = $('#searchInput').val().toLowerCase().trim();
            const lgaVal = $('#lgaSelect').val();
            const typeVal = $('#typeSelect').val();
            const sortVal = $('#sortSelect').val();

            filteredAgents = agentsData.filter(agent => {
                const matchesSearch = agent.name.toLowerCase().includes(searchVal) || 
                                      agent.agency.toLowerCase().includes(searchVal) ||
                                      agent.lgas.some(lga => lga.toLowerCase().includes(searchVal));
                
                const matchesLga = !lgaVal || agent.lgas.includes(lgaVal);
                const matchesType = !typeVal || agent.propertyTypes.includes(typeVal);

                return matchesSearch && matchesLga && matchesType;
            });

            // Sorting selections
            if (sortVal === "listings") {
                filteredAgents.sort((a, b) => b.listingsCount - a.listingsCount);
            } else if (sortVal === "rating") {
                filteredAgents.sort((a, b) => b.rating - a.rating);
            } else if (sortVal === "newest") {
                filteredAgents.sort((a, b) => new Date(b.dateAdded) - new Date(a.dateAdded));
            }

            currentPage = 1;
            renderGrid();
        }

        function clearFilters() {
            $('#searchInput').val('');
            $('#lgaSelect').val('');
            $('#typeSelect').val('');
            $('#sortSelect').val('listings');
            applyFilters();
        }

        function renderGrid() {
            const grid = $('#agentGrid');
            const emptyState = $('#emptyState');
            const paginationSection = $('#paginationSection');
            
            grid.empty();

            if (filteredAgents.length === 0) {
                grid.addClass('d-none');
                emptyState.removeClass('d-none');
                paginationSection.addClass('d-none');
                $('#agent-count-badge').text('0 verified agents');
                return;
            }

            grid.removeClass('d-none');
            emptyState.addClass('d-none');
            paginationSection.removeClass('d-none');

            // Header count badge display
            const totalCount = filteredAgents.length === agentsData.length ? "1,340" : filteredAgents.length;
            $('#agent-count-badge').text(`${totalCount} verified agents`);

            // Paginated indexes calculations
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, filteredAgents.length);
            const paginatedItems = filteredAgents.slice(startIndex, endIndex);

            paginatedItems.forEach(agent => {
                const isTopRated = agent.rating >= 4.5;
                
                // Construct rating stars
                const starIcons = Array.from({length: 5}, (_, i) => {
                    if (i < Math.floor(agent.rating)) {
                        return '<i class="fa-solid fa-star"></i>';
                    }
                    if (i === Math.floor(agent.rating) && agent.rating % 1 !== 0) {
                        return '<i class="fa-solid fa-star-half-stroke"></i>';
                    }
                    return '<i class="fa-regular fa-star"></i>';
                }).join('');

                const lgasSpecialised = agent.lgas.join(', ');

                const cardHtml = `
                    <div class="col-sm-12 col-md-6 col-lg-4 d-flex animate__animated animate__fadeIn">
                        <div class="card box border-0 shadow-sm w-100 agent-card p-4 text-center">
                            ${isTopRated ? '<div class="top-rated-ribbon">Top Rated</div>' : ''}
                            <div class="agent-img-wrapper">
                                <img src="${agent.image}" class="agent-img" alt="${agent.name}">
                            </div>
                            <h4 class="fw-bold mb-1 fs-3" style="color: #14213D;">${agent.name}</h4>
                            <p class="text-muted small mb-2 fw-semibold">${agent.agency}</p>
                            
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1.5 rounded" style="font-size: 0.72rem;">
                                    <i class="fa-solid fa-circle-check me-1"></i> Verified Agent
                                </span>
                            </div>

                            <div class="star-rating d-flex justify-content-center align-items-center gap-1 mb-2">
                                ${starIcons}
                                <span class="text-muted small ms-1">(${agent.reviewsCount} reviews)</span>
                            </div>

                            <div class="spec-meta-block">
                                <div class="small mb-1.5"><span class="fw-semibold text-muted">Active Listings:</span> <span class="badge bg-primary px-2 text-white">${agent.listingsCount} active</span></div>
                                <div class="small text-truncate"><span class="fw-semibold text-muted">Specialises in:</span> ${lgasSpecialised}</div>
                            </div>

                            <p class="text-muted small mt-1 text-start flex-grow-1 agent-bio-trunc">
                                ${agent.bio}
                            </p>

                            <div class="d-flex gap-2 mt-3 w-100">
                                <a href="#" class="btn btn-outline-primary btn-sm flex-grow-1 py-2 fw-semibold">View Profile</a>
                                <a href="#" class="btn btn-primary btn-sm flex-grow-1 py-2 fw-semibold text-light">Message Agent</a>
                            </div>
                        </div>
                    </div>
                `;
                grid.append(cardHtml);
            });

            // Update pagination details
            $('#paginationInfo').text(`Displaying ${startIndex + 1}–${endIndex} of ${filteredAgents.length} agents`);
            renderPagination(filteredAgents.length);
        }

        function renderPagination(totalItems) {
            const paginationUl = $('#paginationLinks');
            paginationUl.empty();

            const totalPages = Math.ceil(totalItems / itemsPerPage);
            if (totalPages <= 1) return;

            // Previous Link
            paginationUl.append(`
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage - 1})"><i class="fa-solid fa-chevron-left"></i></a>
                </li>
            `);

            // Numeric page links
            for (let i = 1; i <= totalPages; i++) {
                paginationUl.append(`
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                    </li>
                `);
            }

            // Next Link
            paginationUl.append(`
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${currentPage + 1})"><i class="fa-solid fa-chevron-right"></i></a>
                </li>
            `);
        }

        function changePage(page) {
            currentPage = page;
            renderGrid();
            
            // Smooth scroll back to search box
            const filterForm = $('#filterForm');
            if (filterForm.length) {
                window.scrollTo({ top: filterForm.offset().top - 120, behavior: 'smooth' });
            }
        }

        // On document ready trigger grid rendering
        $(document).ready(() => {
            renderGrid();
        });
    </script>
</body>
</html>
