<?php
session_start();
require_once "Process_pages/classes/Site.php";
require_once "Process_pages/classes/Tenant.php";
require_once "Process_pages/classes/Utilities.php";
require_once "Process_pages/classes/Db.php";

$user = new Tenant();
$util = new Utilities();

if (isset($_SESSION['useronline'])) {
    $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
}
if (isset($_SESSION['agent_online'])) {
    $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
}

// Fetch all states for the state dropdown
$all_states = $util->fetch_all_states();

// DB query for agents with optional location filter
$db   = new Db();
$conn = $db->connect();

$state_filter = (isset($_GET['state']) && $_GET['state'] !== '') ? (int)$_GET['state'] : null;
$lga_filter   = (isset($_GET['lga'])   && $_GET['lga']   !== '') ? (int)$_GET['lga']   : null;
$search_query = (isset($_GET['q'])     && $_GET['q']     !== '') ? trim($_GET['q'])     : null;
$sort_by      = (isset($_GET['sort'])  && $_GET['sort']  !== '') ? $_GET['sort']        : 'newest';

$where_parts = ["ap.status = 'active'"];
$params = [];

if ($state_filter) {
    $where_parts[] = "s.state_id = ?";
    $params[] = $state_filter;
}
if ($lga_filter) {
    $where_parts[] = "l.LGA_id = ?";
    $params[] = $lga_filter;
}
if ($search_query) {
    $where_parts[] = "(ap.first_name LIKE ? OR ap.last_name LIKE ? OR ap.agency LIKE ? OR l.LGA_name LIKE ? OR s.state LIKE ?)";
    $like   = "%$search_query%";
    $params = array_merge($params, [$like, $like, $like, $like, $like]);
}

$where_sql = implode(' AND ', $where_parts);

$order_map = [
    'listings' => 'listing_count DESC',
    'name'     => 'ap.first_name ASC',
    'newest'   => 'ap.Agent_id DESC',
];
$order_sql = isset($order_map[$sort_by]) ? $order_map[$sort_by] : 'ap.Agent_id DESC';

$sql = "
    SELECT
        ap.Agent_id,
        ap.first_name,
        ap.last_name,
        ap.agency,
        ap.agent_bio,
        ap.years_of_experience,
        ap.profile_picture,
        ap.agency_Location,
        l.LGA_name,
        s.state,
        COUNT(p.property_id) AS listing_count
    FROM agentprofile ap
    LEFT JOIN lga l        ON ap.agency_Location = l.LGA_id
    LEFT JOIN state s      ON l.state_id = s.state_id
    LEFT JOIN properties p ON ap.Agent_id = p.agent_id
    WHERE $where_sql
    GROUP BY ap.Agent_id
    ORDER BY $order_sql
";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $agents = [];
}

$total_agents = count($agents);
$per_page     = 9;
$current_page = (isset($_GET['page'])) ? max(1, (int)$_GET['page']) : 1;
$total_pages  = max(1, (int)ceil($total_agents / $per_page));
$offset       = ($current_page - 1) * $per_page;
$paged_agents = array_slice($agents, $offset, $per_page);

function pagination_url($page) {
    $p = $_GET;
    $p['page'] = $page;
    return 'all_agents.php?' . http_build_query($p);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Real Estate Agents by Location - NaijaRent</title>
    <meta name="description" content="Search and browse verified Nigerian real estate agents by state and LGA on NaijaRent. Find a trusted agent near you today." />
    <meta name="author" content="NaijaRent" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #14213D;
            --brand-blue: #1E3888;
            --brand-grad: linear-gradient(135deg, #14213D, #1E3888);
            --gold:       #FFD700;
            --gold-alt:   #FFA500;
            --surface:    #f4f6fb;
            --card-bg:    #ffffff;
            --radius-lg:  20px;
            --radius-md:  12px;
            --radius-sm:  8px;
            --shadow-md:  0 8px 32px rgba(20,33,61,.10);
            --transition: all .35s cubic-bezier(.165,.84,.44,1);
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: "Inter", sans-serif; background: var(--surface); color: #1a2332; }
        h1, h2, h3, h4, h5, h6 { font-family: "Voltaire", sans-serif; }
        a { text-decoration: none; }

        /* Hero */
        .agents-hero {
            background: var(--brand-grad);
            padding: 72px 0 100px;
            position: relative;
            overflow: hidden;
        }
        .agents-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 80% 50%, rgba(30,56,136,.45) 0%, transparent 70%),
                radial-gradient(ellipse 50% 70% at 10% 80%, rgba(255,215,0,.08) 0%, transparent 60%);
            pointer-events: none;
        }
        .agents-hero .container { position: relative; z-index: 2; }
        .agents-hero h1 { font-size: clamp(2rem, 5vw, 3.2rem); color: #fff; line-height: 1.15; }
        .agents-hero .lead { font-size: 1.05rem; color: rgba(255,255,255,.82); max-width: 680px; margin: 0 auto; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.13); border: 1px solid rgba(255,255,255,.25);
            color: #fff; font-size: .8rem; font-weight: 600; letter-spacing: .5px;
            padding: 6px 18px; border-radius: 50px; backdrop-filter: blur(6px);
        }
        .hero-badge i { color: var(--gold); }

        /* Filter Card */
        .filter-card {
            background: var(--card-bg); border-radius: var(--radius-lg);
            box-shadow: 0 20px 60px rgba(20,33,61,.14); padding: 28px 32px;
            margin-top: -56px; position: relative; z-index: 30;
            border: 1px solid rgba(255,255,255,.9);
        }
        .section-label {
            font-size: .72rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: #8899aa; margin-bottom: 6px; display: block;
        }
        .form-control, .form-select {
            border-radius: var(--radius-sm) !important; border: 1.5px solid #e4e8f0 !important;
            font-size: .9rem; padding: 10px 14px; background: #fafbfd;
            transition: var(--transition); height: 46px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--brand-blue) !important;
            box-shadow: 0 0 0 3px rgba(30,56,136,.12) !important; background: #fff;
        }
        .input-group-text {
            background: #fafbfd; border: 1.5px solid #e4e8f0; border-right: none !important;
            color: #8899aa; border-radius: var(--radius-sm) 0 0 var(--radius-sm) !important;
        }
        .input-group .form-control {
            border-left: none !important;
            border-radius: 0 var(--radius-sm) var(--radius-sm) 0 !important;
        }
        .btn-search {
            background: var(--brand-grad); border: none; color: #fff;
            border-radius: var(--radius-sm) !important; font-weight: 600; font-size: .9rem;
            height: 46px; padding: 0 28px; transition: var(--transition);
            box-shadow: 0 4px 14px rgba(30,56,136,.3);
        }
        .btn-search:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(30,56,136,.38); color: #fff; }
        .btn-reset {
            background: transparent; border: 1.5px solid #dde1ea; color: #8899aa;
            border-radius: var(--radius-sm) !important; font-size: .85rem;
            height: 46px; padding: 0 18px; transition: var(--transition);
        }
        .btn-reset:hover { border-color: var(--brand-blue); color: var(--brand-blue); }
        .active-filter-pill {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(30,56,136,.08); border: 1px solid rgba(30,56,136,.18);
            color: var(--brand-blue); font-size: .75rem; font-weight: 600;
            padding: 3px 10px; border-radius: 50px;
        }

        /* Results Toolbar */
        .results-toolbar {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; padding: 18px 0 4px;
        }
        .results-count { font-size: .88rem; color: #6b7a90; }
        .results-count strong { color: var(--brand-dark); font-size: 1rem; }
        .sort-tabs { display: flex; gap: 6px; }
        .sort-tab {
            font-size: .8rem; font-weight: 600; padding: 5px 14px; border-radius: 50px;
            border: 1.5px solid #dde1ea; color: #6b7a90; background: #fff;
            cursor: pointer; transition: var(--transition);
        }
        .sort-tab:hover, .sort-tab.active { background: var(--brand-grad); border-color: transparent; color: #fff; }

        /* Agent Card */
        .agent-card {
            background: var(--card-bg); border-radius: var(--radius-lg);
            border: 1px solid #eef0f6; overflow: hidden; position: relative;
            transition: var(--transition); display: flex; flex-direction: column; height: 100%;
        }
        .agent-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-md); border-color: rgba(30,56,136,.12); }
        .agent-card-header {
            background: var(--brand-grad); height: 80px; position: relative; overflow: hidden;
        }
        .agent-card-header::after {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 80% 100% at 90% 0%, rgba(255,255,255,.12) 0%, transparent 60%);
        }
        .ribbon {
            position: absolute; top: 12px; right: -26px;
            background: linear-gradient(135deg, var(--gold), var(--gold-alt));
            color: #1a2332; font-size: .6rem; font-weight: 800; letter-spacing: .7px;
            text-transform: uppercase; padding: 4px 30px; transform: rotate(45deg);
            box-shadow: 0 2px 8px rgba(0,0,0,.15); z-index: 5;
        }
        .agent-avatar-wrap {
            width: 86px; height: 86px; border-radius: 50%;
            border: 4px solid #fff; box-shadow: 0 4px 16px rgba(20,33,61,.18);
            position: absolute; bottom: -43px; left: 50%; transform: translateX(-50%);
            background: #eef0f6; overflow: hidden; transition: var(--transition);
        }
        .agent-card:hover .agent-avatar-wrap { border-color: rgba(30,56,136,.35); box-shadow: 0 6px 24px rgba(30,56,136,.25); }
        .agent-avatar-wrap img { width: 100%; height: 100%; object-fit: cover; }
        .avatar-placeholder {
            width: 100%; height: 100%; background: var(--brand-grad);
            display: flex; align-items: center; justify-content: center;
            font-family: "Voltaire", sans-serif; font-size: 1.6rem; color: #fff; font-weight: 700;
        }
        .agent-card-body {
            padding: 52px 20px 20px; text-align: center; flex: 1; display: flex; flex-direction: column;
        }
        .agent-name { font-family: "Voltaire", sans-serif; font-size: 1.25rem; color: var(--brand-dark); margin-bottom: 2px; }
        .agent-agency { font-size: .78rem; color: #8899aa; font-weight: 600; text-transform: uppercase; letter-spacing: .6px; margin-bottom: 10px; }
        .badge-verified {
            display: inline-flex; align-items: center; gap: 4px;
            background: rgba(16,185,129,.1); border: 1px solid rgba(16,185,129,.25);
            color: #059669; font-size: .7rem; font-weight: 700; padding: 3px 10px; border-radius: 50px;
        }
        .agent-meta {
            display: flex; justify-content: center; gap: 20px;
            margin: 14px 0; padding: 12px 0;
            border-top: 1px solid #f0f2f6; border-bottom: 1px solid #f0f2f6;
        }
        .agent-meta-item { display: flex; flex-direction: column; align-items: center; gap: 2px; }
        .agent-meta-item .meta-val { font-family: "Voltaire", sans-serif; font-size: 1.2rem; color: var(--brand-blue); font-weight: 700; line-height: 1; }
        .agent-meta-item .meta-lbl { font-size: .65rem; color: #9aaabb; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
        .meta-divider { width: 1px; height: 32px; background: #eef0f6; align-self: center; }
        .location-tag { display: inline-flex; align-items: center; gap: 5px; font-size: .78rem; color: #6b7a90; margin-bottom: 8px; }
        .location-tag i { color: var(--brand-blue); font-size: .75rem; }
        .agent-bio {
            font-size: .82rem; color: #7a8a9a; line-height: 1.55; flex: 1;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
            overflow: hidden; text-align: left;
        }
        .agent-card-actions { display: flex; gap: 8px; margin-top: 16px; }
        .btn-view {
            flex: 1; background: transparent; border: 1.5px solid var(--brand-blue);
            color: var(--brand-blue); border-radius: var(--radius-sm) !important;
            font-size: .82rem; font-weight: 600; padding: 8px 0;
            transition: var(--transition); text-align: center;
        }
        .btn-view:hover { background: var(--brand-blue); color: #fff; }
        .btn-contact {
            flex: 1; background: var(--brand-grad); border: none; color: #fff;
            border-radius: var(--radius-sm) !important; font-size: .82rem;
            font-weight: 600; padding: 8px 0; transition: var(--transition);
            text-align: center; box-shadow: 0 2px 10px rgba(30,56,136,.25);
        }
        .btn-contact:hover { box-shadow: 0 6px 20px rgba(30,56,136,.38); transform: translateY(-1px); color: #fff; }

        /* Location Tiles */
        .location-section { padding: 60px 0 20px; }
        .location-section h2 { font-size: 1.9rem; color: var(--brand-dark); }
        .loc-tile {
            background: var(--card-bg); border-radius: var(--radius-md);
            border: 1.5px solid #eef0f6; padding: 18px 20px;
            display: flex; align-items: center; gap: 14px;
            cursor: pointer; transition: var(--transition); color: inherit;
        }
        .loc-tile:hover { border-color: var(--brand-blue); box-shadow: 0 6px 24px rgba(30,56,136,.1); transform: translateY(-3px); color: var(--brand-blue); }
        .loc-tile-icon {
            width: 44px; height: 44px; border-radius: 10px;
            background: rgba(30,56,136,.08); display: flex; align-items: center;
            justify-content: center; font-size: 1.1rem; color: var(--brand-blue);
            flex-shrink: 0; transition: var(--transition);
        }
        .loc-tile:hover .loc-tile-icon { background: var(--brand-grad); color: #fff; }
        .loc-tile-name { font-weight: 700; font-size: .95rem; margin-bottom: 1px; }
        .loc-tile-count { font-size: .75rem; color: #9aaabb; }

        /* Empty State */
        .empty-state { text-align: center; padding: 72px 20px; }
        .empty-state-icon { font-size: 4rem; color: #c8d0e0; margin-bottom: 20px; }
        .empty-state h3 { font-size: 1.8rem; color: var(--brand-dark); margin-bottom: 10px; }
        .empty-state p { color: #8899aa; max-width: 480px; margin: 0 auto 24px; }

        /* Pagination */
        .pagination-wrap {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; padding: 24px 0 0;
        }
        .pagination .page-link {
            border-radius: var(--radius-sm) !important; border: 1.5px solid #dde1ea;
            color: var(--brand-blue); font-size: .85rem; font-weight: 600;
            padding: 6px 12px; margin: 0 2px; transition: var(--transition);
        }
        .pagination .page-item.active .page-link {
            background: var(--brand-grad); border-color: transparent;
            color: #fff; box-shadow: 0 4px 14px rgba(30,56,136,.3);
        }
        .pagination .page-link:hover { background: rgba(30,56,136,.08); border-color: var(--brand-blue); }

        /* CTA Banner */
        .cta-banner {
            background: var(--brand-grad); border-radius: var(--radius-lg);
            padding: 52px 40px; position: relative; overflow: hidden; margin: 60px 0;
        }
        .cta-banner::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(ellipse 60% 80% at 90% 50%, rgba(255,215,0,.1) 0%, transparent 60%);
        }
        .cta-banner h2 { color: #fff; font-size: 2rem; }
        .cta-banner p { color: rgba(255,255,255,.8); }
        .btn-cta {
            background: #fff; color: var(--brand-blue); border-radius: 50px !important;
            font-weight: 700; padding: 12px 32px; font-size: .95rem;
            transition: var(--transition); box-shadow: 0 4px 16px rgba(0,0,0,.15);
        }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,0,0,.2); color: var(--brand-dark); }

        /* Spinner */
        .spinner-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(255,255,255,.6); backdrop-filter: blur(4px);
            z-index: 9999; align-items: center; justify-content: center;
        }
        .spinner-overlay.show { display: flex; }

        @media (max-width: 767px) {
            .filter-card { padding: 20px 16px; margin-top: -36px; }
            .agents-hero { padding: 52px 0 80px; }
            .cta-banner { padding: 36px 20px; }
            .sort-tabs { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

<!-- Spinner Overlay -->
<div class="spinner-overlay" id="spinnerOverlay">
    <div class="text-center">
        <div class="spinner-border" role="status" style="width:3rem;height:3rem;color:#1E3888;"></div>
        <p class="mt-3 fw-semibold" style="color:#14213D;">Searching agents...</p>
    </div>
</div>

<?php include 'nav.php'; ?>

<!-- Hero Header -->
<section class="agents-hero text-center animate__animated animate__fadeIn">
    <div class="container">
        <div class="hero-badge mb-3">
            <i class="fa-solid fa-shield-halved"></i>
            <span>All Agents Are Identity-Verified</span>
        </div>
        <h1 class="mb-3">Find Agents by Location</h1>
        <p class="lead mb-0 mx-auto">
            Browse verified Nigerian real estate agents by state and LGA.<br>
            Connect with a trusted professional in your neighbourhood.
        </p>
    </div>
</section>

<!-- Main Container -->
<div class="container pb-5">

    <!-- Search & Filter Card -->
    <div class="filter-card animate__animated animate__fadeInUp">
        <form id="filterForm" method="GET" action="all_agents.php" onsubmit="showSpinner()">
            <div class="row g-3 align-items-end">

                <!-- Keyword Search -->
                <div class="col-12 col-md-4">
                    <span class="section-label">Search Agent</span>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input
                            type="text" id="q" name="q" class="form-control"
                            placeholder="Name, agency or location..."
                            value="<?php echo htmlspecialchars($search_query ?? ''); ?>"
                            autocomplete="off"
                        >
                    </div>
                </div>

                <!-- State Filter -->
                <div class="col-12 col-sm-6 col-md-3">
                    <span class="section-label">
                        <i class="fa-solid fa-map me-1" style="color:var(--brand-blue)"></i>State
                    </span>
                    <select id="stateSelect" name="state" class="form-select">
                        <option value="">All States</option>
                        <?php foreach ($all_states as $st): ?>
                            <option value="<?php echo $st['state_id']; ?>" <?php echo ($state_filter == $st['state_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($st['state']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- LGA Filter (dynamic via AJAX) -->
                <div class="col-12 col-sm-6 col-md-2">
                    <span class="section-label">
                        <i class="fa-solid fa-location-dot me-1" style="color:var(--brand-blue)"></i>LGA
                    </span>
                    <select id="lgaSelect" name="lga" class="form-select">
                        <option value="">All LGAs</option>
                        <?php
                        if ($state_filter) {
                            $lga_util = new Utilities();
                            $pre_lgas = $lga_util->fecht_lga_by_state_id($state_filter);
                            foreach ($pre_lgas as $lga) {
                                $sel = ($lga_filter == $lga['LGA_id']) ? 'selected' : '';
                                echo "<option value='{$lga['LGA_id']}' $sel>" . htmlspecialchars($lga['LGA_name']) . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <!-- Sort By -->
                <div class="col-12 col-sm-6 col-md-2">
                    <span class="section-label">Sort By</span>
                    <select name="sort" id="sortSelect" class="form-select">
                        <option value="newest"   <?php echo ($sort_by === 'newest')   ? 'selected' : ''; ?>>Newest</option>
                        <option value="listings" <?php echo ($sort_by === 'listings') ? 'selected' : ''; ?>>Most Listings</option>
                        <option value="name"     <?php echo ($sort_by === 'name')     ? 'selected' : ''; ?>>A - Z</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-12 col-md-auto d-flex gap-2 align-items-end">
                    <button type="submit" class="btn-search btn" id="searchBtn">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> Search
                    </button>
                    <?php if ($search_query || $state_filter || $lga_filter): ?>
                        <a href="all_agents.php" class="btn-reset btn">
                            <i class="fa-solid fa-xmark me-1"></i> Clear
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Active Filter Pills -->
            <?php if ($search_query || $state_filter || $lga_filter): ?>
            <div class="d-flex flex-wrap gap-2 mt-3 pt-3" style="border-top:1px solid #eef0f6;">
                <span class="text-muted small fw-semibold me-1 align-self-center">Active filters:</span>
                <?php if ($search_query): ?>
                    <span class="active-filter-pill">
                        <i class="fa-solid fa-magnifying-glass fa-xs"></i>
                        "<?php echo htmlspecialchars($search_query); ?>"
                    </span>
                <?php endif; ?>
                <?php if ($state_filter): ?>
                    <?php
                    $st_name = '';
                    foreach ($all_states as $st) {
                        if ($st['state_id'] == $state_filter) { $st_name = $st['state']; break; }
                    }
                    ?>
                    <span class="active-filter-pill">
                        <i class="fa-solid fa-map fa-xs"></i>
                        <?php echo htmlspecialchars($st_name); ?>
                    </span>
                <?php endif; ?>
                <?php if ($lga_filter && !empty($agents) && !empty($agents[0]['LGA_name'])): ?>
                    <span class="active-filter-pill">
                        <i class="fa-solid fa-location-dot fa-xs"></i>
                        <?php echo htmlspecialchars($agents[0]['LGA_name']); ?>
                    </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </form>
    </div>

    <!-- Results Toolbar -->
    <div class="results-toolbar">
        <div class="results-count">
            <?php if ($total_agents > 0): ?>
                Showing <strong><?php echo ($offset + 1); ?> - <?php echo min($offset + $per_page, $total_agents); ?></strong>
                of <strong><?php echo $total_agents; ?></strong> verified agent<?php echo ($total_agents !== 1) ? 's' : ''; ?>
            <?php else: ?>
                <strong>No agents</strong> found matching your criteria
            <?php endif; ?>
        </div>
        <div class="sort-tabs">
            <?php
            $sorts = ['newest' => 'Newest', 'listings' => 'Most Listings', 'name' => 'A - Z'];
            foreach ($sorts as $val => $label):
                $p2 = array_merge($_GET, ['sort' => $val, 'page' => 1]);
            ?>
                <a href="all_agents.php?<?php echo http_build_query($p2); ?>" class="sort-tab <?php echo ($sort_by === $val) ? 'active' : ''; ?>">
                    <?php echo $label; ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Agent Cards Grid -->
    <?php if (!empty($paged_agents)): ?>
    <div class="row g-4 mt-1" id="agentGrid">
        <?php foreach ($paged_agents as $agent):
            $full_name  = htmlspecialchars(trim($agent['first_name'] . ' ' . $agent['last_name']));
            $initials   = strtoupper(substr($agent['first_name'], 0, 1) . substr($agent['last_name'], 0, 1));
            $agency     = htmlspecialchars($agent['agency'] ?? 'Independent Agent');
            $bio        = htmlspecialchars($agent['agent_bio'] ?? '');
            $experience = (int)($agent['years_of_experience'] ?? 0);
            $listings   = (int)$agent['listing_count'];
            $lga_part   = $agent['LGA_name'] ?? '';
            $state_part = $agent['state'] ?? '';
            $sep        = (!empty($lga_part) && !empty($state_part)) ? ', ' : '';
            $location   = htmlspecialchars(trim($lga_part . $sep . $state_part));
            $pic_path   = !empty($agent['profile_picture']) ? 'uploads/' . htmlspecialchars($agent['profile_picture']) : null;
            $is_top     = ($listings >= 5);
        ?>
        <div class="col-sm-6 col-lg-4 d-flex agent-col">
            <div class="agent-card w-100">
                <!-- Card Gradient Header -->
                <div class="agent-card-header">
                    <?php if ($is_top): ?>
                    <div class="ribbon">Top Agent</div>
                    <?php endif; ?>
                </div>
                <!-- Avatar -->
                <div class="agent-avatar-wrap">
                    <?php if ($pic_path): ?>
                        <img src="<?php echo $pic_path; ?>" alt="<?php echo $full_name; ?>">
                    <?php else: ?>
                        <div class="avatar-placeholder"><?php echo $initials; ?></div>
                    <?php endif; ?>
                </div>
                <!-- Card Body -->
                <div class="agent-card-body">
                    <h4 class="agent-name"><?php echo $full_name; ?></h4>
                    <p class="agent-agency"><?php echo $agency; ?></p>
                    <span class="badge-verified mb-2">
                        <i class="fa-solid fa-circle-check fa-sm"></i> Verified Agent
                    </span>
                    <?php if ($location): ?>
                    <div class="location-tag justify-content-center mt-1">
                        <i class="fa-solid fa-location-dot"></i>
                        <span><?php echo $location; ?></span>
                    </div>
                    <?php endif; ?>
                    <!-- Stats Row -->
                    <div class="agent-meta">
                        <div class="agent-meta-item">
                            <span class="meta-val"><?php echo $listings; ?></span>
                            <span class="meta-lbl">Listings</span>
                        </div>
                        <div class="meta-divider"></div>
                        <div class="agent-meta-item">
                            <span class="meta-val"><?php echo ($experience > 0) ? $experience : '--'; ?></span>
                            <span class="meta-lbl">Yrs Exp</span>
                        </div>
                        <div class="meta-divider"></div>
                        <div class="agent-meta-item">
                            <span class="meta-val" style="font-size:.85rem;">
                                <i class="fa-solid fa-star" style="color:var(--gold);font-size:.85rem;"></i> 4.5
                            </span>
                            <span class="meta-lbl">Rating</span>
                        </div>
                    </div>
                    <?php if ($bio): ?>
                    <p class="agent-bio"><?php echo $bio; ?></p>
                    <?php else: ?>
                    <p class="agent-bio text-muted fst-italic">No bio provided yet.</p>
                    <?php endif; ?>
                    <!-- CTA Buttons -->
                    <div class="agent-card-actions">
                        <a href="browse_agents.php?agent=<?php echo (int)$agent['Agent_id']; ?>" class="btn-view">
                            <i class="fa-regular fa-user me-1"></i> Profile
                        </a>
                        <a href="browse_agents.php?agent=<?php echo (int)$agent['Agent_id']; ?>#contact" class="btn-contact">
                            <i class="fa-regular fa-paper-plane me-1"></i> Contact
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
    <div class="pagination-wrap">
        <div class="text-muted small">
            Page <strong><?php echo $current_page; ?></strong> of <strong><?php echo $total_pages; ?></strong>
        </div>
        <nav aria-label="Agent pagination">
            <ul class="pagination mb-0">
                <!-- Previous -->
                <li class="page-item <?php echo ($current_page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo pagination_url($current_page - 1); ?>">
                        <i class="fa-solid fa-chevron-left fa-xs"></i>
                    </a>
                </li>
                <?php
                $sp = max(1, $current_page - 2);
                $ep = min($total_pages, $current_page + 2);
                if ($sp > 1): ?>
                    <li class="page-item"><a class="page-link" href="<?php echo pagination_url(1); ?>">1</a></li>
                    <?php if ($sp > 2): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                <?php endif; ?>
                <?php for ($i = $sp; $i <= $ep; $i++): ?>
                    <li class="page-item <?php echo ($i === $current_page) ? 'active' : ''; ?>">
                        <a class="page-link" href="<?php echo pagination_url($i); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($ep < $total_pages): ?>
                    <?php if ($ep < $total_pages - 1): ?><li class="page-item disabled"><span class="page-link">...</span></li><?php endif; ?>
                    <li class="page-item"><a class="page-link" href="<?php echo pagination_url($total_pages); ?>"><?php echo $total_pages; ?></a></li>
                <?php endif; ?>
                <!-- Next -->
                <li class="page-item <?php echo ($current_page >= $total_pages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="<?php echo pagination_url($current_page + 1); ?>">
                        <i class="fa-solid fa-chevron-right fa-xs"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- Empty State -->
    <div class="empty-state animate__animated animate__fadeIn">
        <div class="empty-state-icon"><i class="fa-regular fa-face-frown-open"></i></div>
        <h3>No Agents Found</h3>
        <p>We couldn't find any verified agents matching your search. Try adjusting your location filter or clearing your search.</p>
        <a href="all_agents.php" class="btn px-5 py-2 rounded-pill fw-semibold text-light shadow-sm"
           style="background:var(--brand-grad);border:none;">
            <i class="fa-solid fa-rotate-left me-2"></i>Reset Search
        </a>
    </div>
    <?php endif; ?>

    <!-- Browse by State Tiles -->
    <?php if (empty($_GET['state']) && empty($_GET['q'])): ?>
    <div class="location-section">
        <h2 class="fw-bold mb-1">Browse Agents by State</h2>
        <p class="text-muted mb-4" style="font-size:.92rem;">
            Select a state to discover verified agents operating in that region.
        </p>
        <div class="row g-3">
            <?php
            $city_icons = [
                'Lagos'    => 'fa-water',
                'Abuja'    => 'fa-building-columns',
                'Rivers'   => 'fa-ship',
                'Oyo'      => 'fa-mosque',
                'Kano'     => 'fa-archway',
                'Enugu'    => 'fa-mountain-city',
                'Anambra'  => 'fa-landmark',
                'Delta'    => 'fa-tree',
                'Kaduna'   => 'fa-fort-awesome',
                'Ogun'     => 'fa-industry',
            ];
            foreach ($all_states as $st):
                $icon = isset($city_icons[$st['state']]) ? $city_icons[$st['state']] : 'fa-map-location-dot';
            ?>
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <a href="all_agents.php?state=<?php echo $st['state_id']; ?>" class="loc-tile">
                    <div class="loc-tile-icon"><i class="fa-solid <?php echo $icon; ?>"></i></div>
                    <div>
                        <div class="loc-tile-name"><?php echo htmlspecialchars($st['state']); ?></div>
                        <div class="loc-tile-count">View agents</div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- CTA Banner -->
    <div class="cta-banner text-center">
        <div class="position-relative" style="z-index:2;">
            <h2 class="mb-2">Are You a Real Estate Agent?</h2>
            <p class="mb-4" style="max-width:520px;margin:0 auto 24px;">
                Join NaijaRent today, get your profile verified, and reach thousands
                of tenants actively searching for properties in your area.
            </p>
            <a href="Agent/agent_plans.php" class="btn-cta btn">
                <i class="fa-solid fa-rocket me-2"></i>Join as an Agent
            </a>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>

<script src="jquery.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    'use strict';

    // Show loading spinner on form submit
    window.showSpinner = function () {
        document.getElementById('spinnerOverlay').classList.add('show');
    };

    // Dynamic LGA cascade on state change
    var stateSelect = document.getElementById('stateSelect');
    var lgaSelect   = document.getElementById('lgaSelect');

    stateSelect.addEventListener('change', function () {
        var stateId = this.value;
        lgaSelect.innerHTML = '<option value="">Loading LGAs...</option>';
        lgaSelect.disabled  = true;

        if (!stateId) {
            lgaSelect.innerHTML = '<option value="">All LGAs</option>';
            lgaSelect.disabled  = false;
            return;
        }

        fetch('Process_pages/process_state_lga.php?state_id=' + stateId)
            .then(function(res) { return res.text(); })
            .then(function(html) {
                lgaSelect.innerHTML = '<option value="">All LGAs</option>' + html;
                lgaSelect.disabled  = false;
            })
            .catch(function() {
                lgaSelect.innerHTML = '<option value="">All LGAs</option>';
                lgaSelect.disabled  = false;
            });
    });

    // Auto-submit when sort changes
    document.getElementById('sortSelect').addEventListener('change', function () {
        showSpinner();
        document.getElementById('filterForm').submit();
    });

    // Staggered card entrance animation via Intersection Observer
    var cols = document.querySelectorAll('.agent-col');
    if ('IntersectionObserver' in window && cols.length) {
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity   = '1';
                    entry.target.style.transform = 'translateY(0)';
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        cols.forEach(function(col, i) {
            col.style.opacity    = '0';
            col.style.transform  = 'translateY(28px)';
            col.style.transition = 'opacity .45s ease ' + (i * 0.08) + 's, transform .45s ease ' + (i * 0.08) + 's';
            io.observe(col);
        });
    }

}());
</script>
</body>
</html>
