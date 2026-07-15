<?php
    session_start();
    require_once "process_pages/classes/Site.php";
    $c = new Site();

    // Validate article ID
    if(!isset($_GET['id']) || empty($_GET['id'])){
        header('location:index.php');
        exit;
    }

    require_once "process_pages/classes/Article.php";
    $article = new Article();
    $res = $article->fetch_article_by_id((int)$_GET['id']);

    if(!$res || is_string($res)){
        header("location:index.php");
        exit;
    }

    require_once("process_pages/classes/Tenant.php");
    $user = new Tenant();
    if(isset($_SESSION['useronline'])){
        $user_deet = $user->fetch_user_detailby_id($_SESSION['useronline']);
    }
    if(isset($_SESSION['agent_online'])){
        $user_deet = $user->fetch_user_detailby_id($_SESSION['agent_online']);
    }

    // Prepare article data
    $artTitle = htmlspecialchars($res['title'] ?? '');
    $artCategory = htmlspecialchars($res['category'] ?? 'Uncategorized');
    $artExcerpt = htmlspecialchars($res['excerpt'] ?? '');
    $artContent = $res['content'] ?? '';
    $artImage = !empty($res['featured_image']) ? htmlspecialchars($res['featured_image']) : 'media/home.png';
    $artDate = !empty($res['created_at']) ? date('F j, Y', strtotime($res['created_at'])) : '';
    $artViews = (int)($res['views'] ?? 0);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $artTitle; ?> | NaijaRent Blog</title>
    <meta name="description" content="<?php echo $artExcerpt; ?>" />
    <meta name="author" content="NaijaRent Admin" />

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="animate.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Voltaire&display=swap" rel="stylesheet">
    <style>
        .article-hero {
            background: linear-gradient(135deg, #14213D 0%, #1E3888 100%);
            padding: 60px 0;
            color: #fff;
        }
        .article-hero .badge {
            font-size: 0.8em;
            letter-spacing: 1px;
            padding: 6px 16px;
            border-radius: 50px;
        }
        .article-hero h1 {
            font-family: 'Voltaire', sans-serif;
            font-size: 2.8em;
            line-height: 1.2;
            margin-top: 20px;
        }
        .article-meta {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            margin-top: 20px;
            font-size: 0.9em;
            opacity: 0.85;
        }
        .article-meta i {
            margin-right: 6px;
        }
        .article-featured-image {
            width: 100%;
            max-height: 480px;
            object-fit: cover;
            border-radius: 12px;
            margin-top: -40px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        .article-content {
            font-size: 1.05em;
            line-height: 1.8;
            color: #374151;
        }
        .article-content p {
            margin-bottom: 1.5em;
        }
        .article-sidebar-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #f0f2f5;
        }
        .article-sidebar-card h5 {
            font-family: 'Voltaire', sans-serif;
            font-size: 1.2em;
            color: #1E3888;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e8f0fe;
        }
        .back-to-blog {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #1E3888;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 24px;
            transition: gap 0.2s;
        }
        .back-to-blog:hover {
            gap: 12px;
            color: #14213D;
        }
        @media (max-width: 768px) {
            .article-hero h1 { font-size: 1.8em; }
            .article-featured-image { margin-top: 0; border-radius: 8px; }
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <?php include 'nav.php'; ?>

    <!-- Article Hero Header -->
    <div class="article-hero">
        <div class="container">
            <a href="index.php#blogSection" class="back-to-blog" style="color: rgba(255,255,255,0.7);">
                <i class="fa-solid fa-arrow-left"></i> Back to Blog
            </a>
            <div>
                <span class="badge bg-warning text-dark"><?php echo $artCategory; ?></span>
            </div>
            <h1><?php echo $artTitle; ?></h1>
            <div class="article-meta">
                <span><i class="fa-regular fa-user"></i> NaijaRent Admin</span>
                <span><i class="fa-regular fa-calendar"></i> <?php echo $artDate; ?></span>
                <span><i class="fa-regular fa-eye"></i> <?php echo number_format($artViews); ?> views</span>
            </div>
        </div>
    </div>

    <!-- Article Body -->
    <div class="container section" style="padding-top: 40px; padding-bottom: 80px;">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Featured Image -->
                <img src="<?php echo $artImage; ?>" alt="<?php echo $artTitle; ?>" class="article-featured-image mb-5">

                <!-- Excerpt -->
                <div class="mb-4" style="font-size: 1.15em; color: #1E3888; font-weight: 500; line-height: 1.7; border-left: 4px solid #1E3888; padding-left: 20px;">
                    <?php echo $artExcerpt; ?>
                </div>

                <!-- Full Content -->
                <div class="article-content">
                    <?php echo nl2br($artContent); ?>
                </div>

                <!-- Share / Tags Footer -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-5 pt-4 border-top">
                    <div class="d-flex gap-2 align-items-center">
                        <span class="fw-semibold" style="color: #14213D;">Share:</span>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fa-brands fa-linkedin-in"></i></a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-pill px-3"><i class="fa-solid fa-link"></i></a>
                    </div>
                    <span class="badge bg-light text-dark px-3 py-2 mt-2 mt-md-0"><?php echo $artCategory; ?></span>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Author Card -->
                <div class="article-sidebar-card mb-4 text-center">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" 
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, #1E3888, #14213D); color: #fff; font-size: 2em;">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <h5 style="border-bottom: none; padding-bottom: 0; text-align: center;">NaijaRent Admin</h5>
                    <p class="text-muted" style="font-size: 0.85em;">Platform Administrator</p>
                    <p style="font-size: 0.9em;">Insights, market updates, and expert tips from the NaijaRent team.</p>
                </div>

                <!-- Article Info Card -->
                <div class="article-sidebar-card mb-4">
                    <h5>Article Info</h5>
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                        <span class="text-muted">Category</span>
                        <span class="fw-semibold"><?php echo $artCategory; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                        <span class="text-muted">Published</span>
                        <span class="fw-semibold"><?php echo $artDate; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                        <span class="text-muted">Author</span>
                        <span class="fw-semibold">Admin</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Views</span>
                        <span class="fw-semibold"><?php echo number_format($artViews); ?></span>
                    </div>
                </div>

                <!-- Related / CTA Card -->
                <div class="article-sidebar-card" style="background: linear-gradient(135deg, #e8f0fe, #fff);">
                    <h5>Stay Updated</h5>
                    <p style="font-size: 0.9em;">Get the latest real estate insights delivered to your inbox.</p>
                    <a href="register.php" class="btn btn-primary w-100 rounded-pill">Subscribe to Newsletter</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script src="jquery.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>