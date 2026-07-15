<?php 
    session_start();
    require_once "adminguard.php";
    require_once "classes/Article.php";
    
    // Fetch articles from database
    $article = new Article();
    $blogs = $article->fetch_all_article();
    
    // Handle case where fetch returns error string
    if (is_string($blogs)) {
        $blogs = [];
    }
    
    // Count stats
    $totalBlogs = count($blogs);
    $publishedBlogs = 0;
    $draftBlogs = 0;
    foreach ($blogs as $b) {
        if (($b['status'] ?? '') === 'Published') {
            $publishedBlogs++;
        } elseif (($b['status'] ?? '') === 'Draft') {
            $draftBlogs++;
        }
    }

    // Session messages
    $successMsg = $_SESSION['blog_success'] ?? '';
    $errorMsgs = $_SESSION['blog_errors'] ?? [];
    $formData = $_SESSION['blog_form_data'] ?? [];

    // Clear session after retrieval
    unset($_SESSION['blog_success'], $_SESSION['blog_errors'], $_SESSION['blog_form_data']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Blog Management</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="../https://fonts.googleapis.com">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="blog.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    
</head>

<body>
    <div class="container-fluid" style="min-height: 100vh;">
        <div class="row" style="min-height: 100vh;">
            <!-- Sidebar -->
            <?php include 'admin_nav.php'; ?>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 px-4 px-lg-5 pb-5 pt-3" style="background:#f4f6fb;">

                <!-- Mobile Menu Toggle -->
                <div class="row mb-3">
                    <div class="col-12 d-md-none">
                        <button class="mobile-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                            <i class="fa-solid fa-bars me-2"></i> Menu
                        </button>
                    </div>
                </div>

                <!-- Page Header -->
                <div class="row mt-3 mb-4">
                    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h2 class="mb-1" style="font-family:'Inter',sans-serif;font-weight:700;">Blog Management</h2>
                            <p class="mb-0" style="color:#6b7280;font-size:0.9em;">Create, edit, and manage blog posts</p>
                        </div>
                        <button type="button" class="btn-create-blog" data-bs-toggle="offcanvas" data-bs-target="#createBlogOffcanvas">
                            <i class="fa-solid fa-plus"></i> Create Blog
                        </button>
                    </div>
                </div>

                <!-- Session Messages -->
                <?php if ($successMsg): ?>
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" style="border-radius:8px;border:none;background:#ecfdf5;color:#065f46;font-size:0.9em;padding:12px 16px;">
                        <i class="fa-regular fa-circle-check"></i> <?php echo htmlspecialchars($successMsg); ?>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (!empty($errorMsgs)): ?>
                    <div class="alert alert-danger alert-dismissible fade show d-flex flex-column gap-1" style="border-radius:8px;border:none;background:#fef2f2;color:#991b1b;font-size:0.9em;padding:12px 16px;">
                        <?php foreach ($errorMsgs as $err): ?>
                            <div><i class="fa-regular fa-circle-exclamation me-1"></i> <?php echo htmlspecialchars($err); ?></div>
                        <?php endforeach; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="stat-card-blog d-flex align-items-center gap-3">
                            <div class="stat-icon-blog"><i class="fa-regular fa-file-lines"></i></div>
                            <div>
                                <div class="stat-number"><?php echo $totalBlogs; ?></div>
                                <div class="stat-label">Total Posts</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card-blog d-flex align-items-center gap-3">
                            <div class="stat-icon-blog" style="color:#065f46;"><i class="fa-regular fa-circle-check"></i></div>
                            <div>
                                <div class="stat-number"><?php echo $publishedBlogs; ?></div>
                                <div class="stat-label">Published</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-card-blog d-flex align-items-center gap-3">
                            <div class="stat-icon-blog" style="color:#92400e;"><i class="fa-regular fa-pen-to-square"></i></div>
                            <div>
                                <div class="stat-number"><?php echo $draftBlogs; ?></div>
                                <div class="stat-label">Drafts</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Bar -->
                <div class="row g-3 mb-4 align-items-center">
                    <div class="col-md-5 col-lg-4">
                        <div class="search-input-group">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" class="form-control" placeholder="Search blog posts..." id="blogSearch" onkeyup="filterBlogs()">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <select class="filter-select w-100" id="statusFilter" onchange="filterBlogs()">
                            <option value="all">All Status</option>
                            <option value="Published">Published</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <select class="filter-select w-100" id="categoryFilter" onchange="filterBlogs()">
                            <option value="all">All Categories</option>
                            <option value="Renting Tips">Renting Tips</option>
                            <option value="Guides">Guides</option>
                            <option value="Market Insights">Market Insights</option>
                            <option value="Property Management">Property Management</option>
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button class="btn-outline-blog" onclick="resetFilters()">
                            <i class="fa-solid fa-rotate-left me-1"></i> Reset
                        </button>
                    </div>
                </div>

                <!-- Blog Posts Grid -->
                <div class="row g-4" id="blogGrid">
                    <?php if (empty($blogs)): ?>
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="fa-regular fa-newspaper"></i>
                                <h5>No blog posts yet</h5>
                                <p>Create your first blog post to get started.</p>
                                <button type="button" class="btn-create-blog" data-bs-toggle="offcanvas" data-bs-target="#createBlogOffcanvas">
                                    <i class="fa-solid fa-plus"></i> Create Blog
                                </button>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($blogs as $blog): ?>
                            <?php 
                                $imgSrc = !empty($blog['featured_image']) ? '../' . htmlspecialchars($blog['featured_image']) : '../media/home.png';
                                $blogTitle = htmlspecialchars($blog['title'] ?? '');
                                $blogCategory = htmlspecialchars($blog['category'] ?? 'Uncategorized');
                                $blogStatus = htmlspecialchars($blog['status'] ?? 'Draft');
                                $blogExcerpt = htmlspecialchars($blog['excerpt'] ?? '');
                                $blogAuthor = htmlspecialchars($blog['author'] ?? 'Admin');
                                $blogDate = !empty($blog['created_at']) ? date('M j, Y', strtotime($blog['created_at'])) : date('M j, Y');
                                $blogViews = $blog['views'] ?? 0;
                            ?>
                            <div class="col-md-6 col-lg-4 blog-item" 
                                 data-title="<?php echo strtolower($blogTitle); ?>"
                                 data-status="<?php echo $blogStatus; ?>"
                                 data-category="<?php echo $blogCategory; ?>">
                                <div class="blog-card">
                                    <img src="../media/blog_images/<?php echo $imgSrc; ?>" alt="<?php echo $blogTitle; ?>" class="blog-img">
                                    <div class="blog-body">
                                        <div class="blog-meta">
                                            <span class="blog-category"><?php echo $blogCategory; ?></span>
                                            <span class="status-badge-sm <?php echo strtolower($blogStatus); ?>"><?php echo $blogStatus; ?></span>
                                        </div>
                                        <h5 class="blog-title"><?php echo $blogTitle; ?></h5>
                                        <p class="blog-excerpt"><?php echo $blogExcerpt; ?></p>
                                        <div class="blog-footer">
                                            <div>
                                                <span><i class="fa-regular fa-user me-1"></i><?php echo $blogAuthor; ?></span>
                                                <span class="ms-3"><i class="fa-regular fa-calendar me-1"></i><?php echo $blogDate; ?></span>
                                            </div>
                                            <div class="blog-views">
                                                <i class="fa-regular fa-eye"></i> <?php echo $blogViews; ?>
                                            </div>
                                        </div>
                                        <div class="blog-actions mt-3">
                                            <button title="Edit"><i class="fa-regular fa-pen-to-square me-1"></i> Edit</button>
                                            <button title="View"><i class="fa-regular fa-eye me-1"></i> View</button>
                                            <button class="btn-delete-blog" title="Delete"><i class="fa-regular fa-trash-can me-1"></i> Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Create Blog Offcanvas -->
    <div class="offcanvas offcanvas-end offcanvas-blog" tabindex="-1" id="createBlogOffcanvas" aria-labelledby="createBlogOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="createBlogOffcanvasLabel">
                <i class="fa-regular fa-pen-to-square me-2" style="color:#1E3888;"></i> Create New Blog Post
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="Process_pages/process_article.php" method="post" enctype="multipart/form-data">
                <!-- Title -->
                <div class="mb-3">
                    <label for="blogTitle" class="form-label-custom">Blog Title</label>
                    <input type="text" class="form-control form-control-custom" id="blogTitle" name="title" placeholder="Enter blog post title" required
                           value="<?php echo htmlspecialchars($formData['title'] ?? ''); ?>">
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="blogCategory" class="form-label-custom">Category</label>
                    <select class="form-control-custom w-100" id="blogCategory" name="category" required>
                        <option value="">Select category</option>
                        <?php 
                            $cats = ['Renting Tips', 'Guides', 'Market Insights', 'Property Management', 'News', 'Other'];
                            $selectedCat = $formData['category'] ?? '';
                            foreach ($cats as $cat): 
                        ?>
                            <option value="<?php echo $cat; ?>" <?php echo $selectedCat === $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="blogStatus" class="form-label-custom">Status</label>
                    <select class="form-control-custom w-100" id="blogStatus" name="blog_status">
                        <?php 
                            $selectedStatus = $formData['blog_status'] ?? 'Published';
                        ?>
                        <option value="Draft" <?php echo $selectedStatus === 'Draft' ? 'selected' : ''; ?>>Draft</option>
                        <option value="Published" <?php echo $selectedStatus === 'Published' ? 'selected' : ''; ?>>Published</option>
                    </select>
                </div>

                <!-- Excerpt -->
                <div class="mb-3">
                    <label for="blogExcerpt" class="form-label-custom">Excerpt</label>
                    <textarea class="form-control form-control-custom" id="blogExcerpt" name="excerpt" rows="3" placeholder="Brief summary of the blog post" required><?php echo htmlspecialchars($formData['excerpt'] ?? ''); ?></textarea>
                </div>

                <!-- Content -->
                <div class="mb-3">
                    <label for="blogContent" class="form-label-custom">Content</label>
                    <textarea class="form-control form-control-custom" id="blogContent" name="content" rows="8" placeholder="Write your blog post content here..." required><?php echo htmlspecialchars($formData['content'] ?? ''); ?></textarea>
                </div>

                <!-- Featured Image Upload -->
                <div class="mb-3">
                    <label class="form-label-custom">Featured Image</label>
                    <div class="file-upload-area" onclick="document.getElementById('blogImage').click();">
                        <i class="fa-regular fa-image"></i>
                        <p>Click to upload featured image</p>
                        <div class="file-hint">PNG, JPG or WebP (Max 2MB)</div>
                        <input type="file" class="d-none" id="blogImage" name="featured_image" accept="image/png,image/jpeg,image/webp">
                    </div>
                    <div id="imagePreview" class="mt-2 d-none">
                        <img src="" alt="Preview" style="max-width:100%;max-height:160px;border-radius:6px;border:1px solid #e9edf2;">
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="removeImage()" style="font-size:0.78em;">Remove</button>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex gap-2 pt-3 border-top" style="border-color:#f0f2f5 !important;">
                    <button type="button" class="btn-outline-blog flex-fill" data-bs-dismiss="offcanvas">Cancel</button>
                    <button type="submit" class="btn-primary-blog flex-fill" name="create_blog">
                        <i class="fa-regular fa-floppy-disk me-1"></i> Save Blog Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        // ── Image Upload Preview ─────────────────────────
        document.getElementById('blogImage')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    const preview = document.getElementById('imagePreview');
                    preview.classList.remove('d-none');
                    preview.querySelector('img').src = ev.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('blogImage').value = '';
            document.getElementById('imagePreview').classList.add('d-none');
            document.getElementById('imagePreview').querySelector('img').src = '';
        }

        // ── Search & Filter ─────────────────────────────
        function filterBlogs() {
            const search = document.getElementById('blogSearch').value.toLowerCase().trim();
            const status = document.getElementById('statusFilter').value;
            const category = document.getElementById('categoryFilter').value;
            const items = document.querySelectorAll('.blog-item');

            items.forEach(item => {
                const title = item.getAttribute('data-title') || '';
                const itemStatus = item.getAttribute('data-status') || '';
                const itemCategory = item.getAttribute('data-category') || '';

                const matchesSearch = title.includes(search);
                const matchesStatus = status === 'all' || itemStatus === status;
                const matchesCategory = category === 'all' || itemCategory === category;

                item.style.display = matchesSearch && matchesStatus && matchesCategory ? '' : 'none';
            });
        }

        function resetFilters() {
            document.getElementById('blogSearch').value = '';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('categoryFilter').value = 'all';
            filterBlogs();
        }
    </script>
</body>

</html>