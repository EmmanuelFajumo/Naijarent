<?php
session_start();
require_once "../classes/Article.php";

// Redirect back to blog page constant
define("BLOG_PAGE", "../admin_dashboard_blog.php");

// Ensure directory exists for uploads
$upload_dir = __DIR__ . "/../../media/blog_images/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if (isset($_POST["create_blog"])) {

    // Collect form data
    $title = trim($_POST["title"] ?? "");
    $category = trim($_POST["category"] ?? "");
    $status = trim($_POST["blog_status"] ?? "");
    $excerpt = trim($_POST["excerpt"] ?? "");
    $content = trim($_POST["content"] ?? "");

    // Validate required fields
    $errors = [];
    if (empty($title)) {
        $errors[] = "Blog title is required.";
    }
    if (empty($category)) {
        $errors[] = "Category is required.";
    }
    if (empty($excerpt)) {
        $errors[] = "Excerpt is required.";
    }
    if (empty($content)) {
        $errors[] = "Content is required.";
    }
    if (empty($status)) {
        $status = "Draft";
    }

    // Handle featured image upload
    $featured_image = "";
    if (isset($_FILES["featured_image"]) && $_FILES["featured_image"]["error"] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES["featured_image"]["tmp_name"];
        $file_name = $_FILES["featured_image"]["name"];
        $file_size = $_FILES["featured_image"]["size"];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_exts = ["png", "jpg", "jpeg", "webp"];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (!in_array($file_ext, $allowed_exts)) {
            $errors[] = "Invalid image format. Allowed: PNG, JPG, JPEG, WebP.";
        }

        if ($file_size > $max_size) {
            $errors[] = "Image file size must not exceed 2MB.";
        }

        if (empty($errors)) {
            // Generate unique filename
            $new_filename = "blog_" . time() . "_" . uniqid() . "." . $file_ext;
            $destination = $upload_dir . $new_filename;

            if (move_uploaded_file($file_tmp, $destination)) {
                $featured_image = "./../media/blog_images/" . $new_filename;
            } else {
                $errors[] = "Failed to upload featured image.";
            }
        }
    }

    // If there are errors, store them in session and redirect
    if (!empty($errors)) {
        $_SESSION["blog_errors"] = $errors;
        $_SESSION["blog_form_data"] = $_POST;
        header("Location: " . BLOG_PAGE);
        exit();
    }

    // Insert into database
    $article = new Article();
    $result = $article->insert_article($title, $category, $status, $excerpt, $content, $featured_image);

    if ($result === true) {
        $_SESSION["blog_success"] = "Blog post has been created successfully!";
    } else {
        $_SESSION["blog_errors"] = ["Database error: " . $result];
    }

    header("Location: " . BLOG_PAGE);
    exit();
}

// If accessed directly without form submission
header("Location: " . BLOG_PAGE);
exit();