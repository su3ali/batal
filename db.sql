-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 02, 2023 at 06:46 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `first_name`, `last_name`, `email`, `phone`, `message`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '‪ahmed', 'hussein‬‏', 'ahmed.hussein.202050@gmail.com', NULL, 'asdasfd sadffsdaaf sdf sadf sad fsaf sadf', '2023-03-01 17:52:27', '2023-03-01 17:52:27', NULL),
(2, '‪ahmed', 'hussein‬‏', 'ahmed.hussein.202050@gmail.com', NULL, 'asdasdadf asdasdf', '2023-03-01 17:53:22', '2023-03-01 17:53:22', NULL),
(3, '‪ahmed', 'hussein‬‏', 'ahmed.hussein.202050@gmail.com', NULL, 'asdadf asfdasdf asdasfdas', '2023-03-01 17:55:23', '2023-03-01 17:55:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint UNSIGNED NOT NULL,
  `question` json NOT NULL,
  `answer` json NOT NULL,
  `created_by_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `title` json NOT NULL,
  `description` json DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_sections`
--

CREATE TABLE `home_sections` (
  `id` bigint UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` json DEFAULT NULL,
  `description` json DEFAULT NULL,
  `created_by_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_sections`
--

INSERT INTO `home_sections` (`id`, `type`, `title`, `description`, `created_by_type`, `created_by_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'about', '{\"ar\": \"عنوان1\", \"en\": \"Address2\"}', '{\"ar\": \"<h2><br>ديجتال فود مستقبل المطاعم</h2><p>قم بتصميم قائمة طعامك بهوية وألوان علامتك التجارية وتميز بمنح عملائك فرصة عيش تجربة إلكترونية رائعة من خلال استعراضهم المنيو الذكي وتحديد خياراتهم وإكمال الطلب والدفع بخطوات إلكترونية متكاملة</p><p><strong>عزز مبيعاتك وأسعد عملائك مع ديجتال فود</strong></p>\", \"en\": \"<h2><br>Digital Food is the future of restaurants</h2><p>Design your menu with your brand\'s identity and colors, and be distinguished by giving your customers the opportunity to live a wonderful electronic experience by browsing the smart menu, selecting their options, completing the order, and paying with integrated electronic steps</p><p><strong>Boost your sales and delight your customers with Digital Food</strong></p>\"}', NULL, NULL, '2023-02-26 15:13:07', '2023-03-02 00:56:24', NULL),
(2, 'about', '{\"ar\": \"عنوان1\", \"en\": \"Address2\"}', '{\"ar\": \"<ul><li><strong>تنسيق المنيو بشعارك وهوية علامتك التجارية</strong></li><li><strong>متوافق مع اشتراطات البلدية وهيئة الغذاء والدواء</strong></li><li><strong>استعراض المنيو والطلب ودفع الحساب إلكترونياً</strong></li><li><strong>التحكم بالمنيو وإضافة العروض التسويقية خلال لحظات وفي أي وقت</strong></li><li><strong>مشاركة المنيو مع عملائك على قوقل وحسابات التواصل الاجتماعي</strong></li><li><strong>خفض التكاليف وزيادة المبيعات بأكثر من 30%</strong></li><li><strong>دعم فني على مدار الساعة</strong></li></ul>\", \"en\": \"<ul><li><strong>Format the menu with your logo and brand identity</strong></li><li><strong>Compliant with the requirements of the municipality and the Food and Drug Authority</strong></li><li><strong>View menu, order and pay online</strong></li><li><strong>Control the menu and add marketing offers in moments and at any time</strong></li><li><strong>Share the menu with your customers on Google and social media</strong></li><li><strong>Reduce costs and increase sales by more than 30%</strong></li><li><strong>24/7 technical support</strong></li></ul>\"}', NULL, NULL, '2023-02-26 15:13:07', '2023-03-02 00:57:59', NULL),
(3, 'about', '{\"ar\": \"عنوان1\", \"en\": \"Address2\"}', '{\"ar\": \"<h2><span style=\\\"color:#c0392b;\\\">تميز بعرض قائمتك بشكل احترافي وجذاب</span></h2>\\r\\n\\r\\n<p>خيارات متعددة لعرض أصنافك تتناسب مع تفاصيل منتجاتك قابلة للتعديل في أي وقت وبشكل فوري</p>\", \"en\": \"<h2>Display your listing professionally and attractively</h2>\\r\\n\\r\\n<p>Multiple options for displaying your items that are compatible with your product details and can be modified at any time and immediately</p>\"}', NULL, NULL, '2023-02-26 15:13:07', '2023-03-02 01:53:23', NULL),
(6, 'feature', '{\"ar\": \"خدمات ذاتية\", \"en\": \"Self-service\"}', '{\"ar\": \"<h4><strong>خدمات ذاتية</strong></h4><p>اجراءات الطلب والاستلام والدفع جميعها بخطوات الكترونية سلسة بدون تدخل الموظف</p>\", \"en\": \"<h4><strong>Self-service</strong></h4><p>The application, receipt and payment procedures are all in smooth electronic steps without employee intervention</p>\"}', NULL, NULL, '2023-03-02 01:05:14', '2023-03-02 01:05:42', NULL),
(7, 'feature', '{\"ar\": \"خدمات ذاتية\", \"en\": \"Self-service\"}', '{\"ar\": \"<h4><strong>خدمات ذاتية</strong></h4>\\r\\n\\r\\n<p>اجراءات الطلب والاستلام والدفع جميعها بخطوات الكترونية سلسة بدون تدخل الموظف</p>\", \"en\": \"<h4><strong>Self-service</strong></h4>\\r\\n\\r\\n<p>The application, receipt and payment procedures are all in smooth electronic steps without employee intervention</p>\"}', NULL, NULL, '2023-03-02 01:06:27', '2023-03-02 04:23:33', NULL),
(8, 'feature', '{\"ar\": \"خدمات ذاتية\", \"en\": \"Self-service\"}', '{\"ar\": \"<h4><strong>خدمات ذاتية</strong></h4><p>اجراءات الطلب والاستلام والدفع جميعها بخطوات الكترونية سلسة بدون تدخل الموظف</p>\", \"en\": \"<h4><strong>Self-service</strong></h4><p>The application, receipt and payment procedures are all in smooth electronic steps without employee intervention</p>\"}', NULL, NULL, '2023-03-02 01:07:09', '2023-03-02 01:07:09', NULL),
(9, 'feature', '{\"ar\": \"خدمات ذاتية\", \"en\": \"Self-service\"}', '{\"ar\": \"<h4><strong>خدمات ذاتية</strong></h4><p>اجراءات الطلب والاستلام والدفع جميعها بخطوات الكترونية سلسة بدون تدخل الموظف</p>\", \"en\": \"<h4><strong>Self-service</strong></h4><p>The application, receipt and payment procedures are all in smooth electronic steps without employee intervention</p>\"}', NULL, NULL, '2023-03-02 01:07:51', '2023-03-02 01:07:51', NULL),
(10, 'feature', '{\"ar\": \"خدمات ذاتية\", \"en\": \"Self-service\"}', '{\"ar\": \"<h4><strong>خدمات ذاتية</strong></h4><p>اجراءات الطلب والاستلام والدفع جميعها بخطوات الكترونية سلسة بدون تدخل الموظف</p>\", \"en\": \"<h4><strong>Self-service</strong></h4><p>The application, receipt and payment procedures are all in smooth electronic steps without employee intervention</p>\"}', NULL, NULL, '2023-03-02 01:08:32', '2023-03-02 01:08:32', NULL),
(11, 'success_partners', '{\"en\": null}', '{\"en\": null}', NULL, NULL, '2023-03-02 01:28:11', '2023-03-02 01:28:11', NULL),
(12, 'success_partners', '{\"en\": null}', '{\"ar\": \"<h2><span style=\\\"color:#c0392b;\\\">تميز بعرض قائمتك بشكل احترافي وجذاب</span></h2>\\r\\n\\r\\n<p>خيارات متعددة لعرض أصنافك تتناسب مع تفاصيل منتجاتك قابلة للتعديل في أي وقت وبشكل فوري</p>\", \"en\": null}', NULL, NULL, '2023-03-02 01:29:22', '2023-03-02 01:52:39', NULL),
(13, 'success_partners', '{\"en\": null}', '{\"en\": null}', NULL, NULL, '2023-03-02 01:29:35', '2023-03-02 01:29:35', NULL),
(14, 'success_partners', '{\"en\": null}', '{\"en\": null}', NULL, NULL, '2023-03-02 01:29:53', '2023-03-02 01:29:53', NULL),
(15, 'success_partners', '{\"en\": null}', '{\"en\": null}', NULL, NULL, '2023-03-02 01:30:08', '2023-03-02 01:30:08', NULL),
(16, 'success_partners', '{\"en\": null}', '{\"en\": null}', NULL, NULL, '2023-03-02 01:30:22', '2023-03-02 01:30:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `local` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direction` enum('rtl','ltr') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rtl',
  `rtl` tinyint(1) NOT NULL DEFAULT '0',
  `sort` tinyint DEFAULT NULL,
  `col` int DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '0' COMMENT '0 -> Disable , 1 -> Enable',
  `lock` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `flag`, `code`, `local`, `direction`, `rtl`, `sort`, `col`, `active`, `lock`, `created_at`, `updated_at`) VALUES
(1, 'العربية', 'storage/language/ar/ar-sa-large.png', 'ar', 'ar-SA', 'rtl', 1, 1, 1, 1, 1, NULL, NULL),
(2, 'English', 'storage/language/en/en-us-large.png', 'en', 'en-US', 'ltr', 0, 2, 2, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint UNSIGNED NOT NULL,
  `manipulations` json NOT NULL,
  `custom_properties` json NOT NULL,
  `generated_conversions` json NOT NULL,
  `responsive_images` json NOT NULL,
  `order_column` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 1, '25a324f9-57b4-4bc4-8464-90d8f1ce4788', 'avatar', 'amaak', 'amaak.jpg', 'image/jpeg', 'public', 'public', 20461, '[]', '[]', '[]', '[]', 1, '2023-02-26 15:15:40', '2023-02-26 15:15:40'),
(4, 'App\\Models\\Package', 1, 'd51128d3-5b22-4b9f-a322-942d677f724f', 'image', 'amaak', 'amaak.jpg', 'image/jpeg', 'public', 'public', 20461, '[]', '[]', '[]', '[]', 2, '2023-03-01 16:11:44', '2023-03-01 16:11:44'),
(5, 'App\\Models\\Package', 2, 'aca3acb2-5242-43fb-8c4e-d59dfa9b877b', 'image', 'amaak1', 'amaak1.jpg', 'image/jpeg', 'public', 'public', 10827, '[]', '[]', '[]', '[]', 3, '2023-03-01 16:12:57', '2023-03-01 16:12:57'),
(6, 'App\\Models\\Package', 3, '75e80d9b-c83a-4c4e-ae77-f0cb482cb520', 'image', '1', '1.jpg', 'image/jpeg', 'public', 'public', 4803, '[]', '[]', '[]', '[]', 4, '2023-03-01 16:13:58', '2023-03-01 16:13:58'),
(9, 'App\\Models\\HomeSection', 6, 'cc127115-1f57-4a6a-bf62-c36b8d2ccd8c', 'image', 'f1', 'f1.png', 'image/png', 'public', 'public', 134962, '[]', '[]', '[]', '[]', 5, '2023-03-02 01:05:14', '2023-03-02 01:05:14'),
(10, 'App\\Models\\HomeSection', 7, 'acf1763a-bc59-4014-aa38-552de47acf22', 'image', 'f2', 'f2.png', 'image/png', 'public', 'public', 164368, '[]', '[]', '[]', '[]', 6, '2023-03-02 01:06:28', '2023-03-02 01:06:28'),
(11, 'App\\Models\\HomeSection', 8, '80b27431-3461-4e66-8655-3272c1b005ad', 'image', 'f3', 'f3.png', 'image/png', 'public', 'public', 147193, '[]', '[]', '[]', '[]', 7, '2023-03-02 01:07:09', '2023-03-02 01:07:09'),
(12, 'App\\Models\\HomeSection', 9, '3142d807-926b-41bf-83b7-cf08c5544ad3', 'image', 'f4', 'f4.png', 'image/png', 'public', 'public', 182152, '[]', '[]', '[]', '[]', 8, '2023-03-02 01:07:51', '2023-03-02 01:07:51'),
(13, 'App\\Models\\HomeSection', 10, 'bde85be1-bd34-479b-a5f0-1e102642d8d4', 'image', 'f5', 'f5.png', 'image/png', 'public', 'public', 142502, '[]', '[]', '[]', '[]', 9, '2023-03-02 01:08:32', '2023-03-02 01:08:32'),
(16, 'App\\Models\\HomeSection', 11, '825733d4-4be7-444c-8b4c-b53d6e7d025c', 'image', 'su1', 'su1.png', 'image/png', 'public', 'public', 13630, '[]', '[]', '[]', '[]', 10, '2023-03-02 01:28:52', '2023-03-02 01:28:52'),
(17, 'App\\Models\\HomeSection', 12, '4b05f826-a06c-47e0-8569-9aa653028e67', 'image', 'su2', 'su2.png', 'image/png', 'public', 'public', 19849, '[]', '[]', '[]', '[]', 11, '2023-03-02 01:29:22', '2023-03-02 01:29:22'),
(18, 'App\\Models\\HomeSection', 13, '793dc6cc-34d9-4f95-b73b-b5c82162808e', 'image', 'su3', 'su3.png', 'image/png', 'public', 'public', 20305, '[]', '[]', '[]', '[]', 12, '2023-03-02 01:29:35', '2023-03-02 01:29:35'),
(19, 'App\\Models\\HomeSection', 14, '1a91c256-d5f1-480d-8ce7-3e338e27dae3', 'image', 'su4', 'su4.png', 'image/png', 'public', 'public', 31422, '[]', '[]', '[]', '[]', 13, '2023-03-02 01:29:53', '2023-03-02 01:29:53'),
(20, 'App\\Models\\HomeSection', 15, 'f45071e8-19db-4cba-b240-9160825d8fc7', 'image', 'su5', 'su5.png', 'image/png', 'public', 'public', 9069, '[]', '[]', '[]', '[]', 14, '2023-03-02 01:30:08', '2023-03-02 01:30:08'),
(21, 'App\\Models\\HomeSection', 16, 'cdf7ee66-7cc5-4e6f-b614-b8b5cfb4dc11', 'image', 'su6', 'su6.png', 'image/png', 'public', 'public', 121509, '[]', '[]', '[]', '[]', 15, '2023-03-02 01:30:22', '2023-03-02 01:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_06_22_113255_create_pages_table', 1),
(6, '2022_06_22_114152_create_settings_table', 1),
(7, '2022_06_22_133822_create_media_table', 1),
(8, '2022_06_22_153203_create_permission_tables', 1),
(9, '2022_09_27_030816_create_temporary_uploads_table', 1),
(10, '2022_10_03_113009_create_galleries_table', 1),
(11, '2022_10_12_130438_create_contact_us_table', 1),
(12, '2022_10_16_084446_create_faqs_table', 1),
(13, '2023_02_05_114332_create_home_sections_table', 1),
(14, '2023_02_05_134715_create_packages_table', 1),
(15, '2023_02_08_002421_create_languages_table', 1),
(16, '2023_02_12_155659_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `title` json NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT '0',
  `description` json DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint UNSIGNED NOT NULL,
  `price` double DEFAULT NULL,
  `title` json NOT NULL,
  `description` json DEFAULT NULL,
  `created_by_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `price`, `title`, `description`, `created_by_type`, `created_by_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 150, '{\"ar\": \"الباقه الفضية\", \"en\": \"Silver package\"}', '{\"ar\": \"<ul><li><strong>منيو طلب ذاتي</strong></li><li><strong>عدد 1-10 فروع (99$ للفرع الواحد شهرياً)</strong></li></ul><h4><strong>الميزات :</strong></h4><ul><li>عدد 4 مستخدمين على لوحة التحكم لكل فرع</li><li>أربع ساعات تدريبية (أون لاين)</li><li>إمكانية دعم الفوترة الإلكترونية</li><li>إمكانية الدفع كاش و أون لاين</li><li>عدد لا محدود من العملاء</li><li>عدد لا محدود من العروض والكوبونات</li><li>الدعم الفني 24/7</li><li>عدد لا محدود من الأقسام والوجبات</li><li>نظام إدارة صلاحيات متكامل</li><li>مدة تجريبية 10 أيام</li></ul><p><br>&nbsp;</p>\", \"en\": \"<ul><li><strong>Self-order menu</strong></li><li><strong>1-10 branches ($99 per branch per month)</strong></li></ul><h4><strong>Features :</strong></h4><ul><li>4 users on the control panel per branch</li><li>Four hours of training (online)</li><li>electronic billing support</li><li>Possibility of online and cash payments</li><li>Unlimited number of customers</li><li>Unlimited offers and coupons</li><li>Technical support 24/7</li><li>Unlimited number of sections and meals</li><li>Integrated authorization management system</li><li>10 day trial period</li></ul>\"}', NULL, NULL, '2023-03-01 16:11:43', '2023-03-02 01:12:40', NULL),
(4, 500, '{\"ar\": \"الباقه الذهبية\", \"en\": \"Golden package\"}', '{\"ar\": \"<ul>\\r\\n\\t<li><strong>منيو طلب ذاتي</strong></li>\\r\\n\\t<li><strong>عدد 1-10 فروع (99$ للفرع الواحد شهرياً)</strong></li>\\r\\n</ul>\\r\\n\\r\\n<h4><strong>الميزات :</strong></h4>\\r\\n\\r\\n<ul>\\r\\n\\t<li>عدد 4 مستخدمين على لوحة التحكم لكل فرع</li>\\r\\n\\t<li>أربع ساعات تدريبية (أون لاين)</li>\\r\\n\\t<li>إمكانية دعم الفوترة الإلكترونية</li>\\r\\n\\t<li>إمكانية الدفع كاش و أون لاين</li>\\r\\n\\t<li>عدد لا محدود من العملاء</li>\\r\\n\\t<li>عدد لا محدود من العروض والكوبونات</li>\\r\\n\\t<li>الدعم الفني 24/7</li>\\r\\n\\t<li>عدد لا محدود من الأقسام والوجبات</li>\\r\\n\\t<li>نظام إدارة صلاحيات متكامل</li>\\r\\n\\t<li>مدة تجريبية 10 أيام</li>\\r\\n</ul>\\r\\n\\r\\n<p><br />\\r\\n&nbsp;</p>\", \"en\": \"<ul>\\r\\n\\t<li><strong>Self-order menu</strong></li>\\r\\n\\t<li><strong>1-10 branches ($99 per branch per month)</strong></li>\\r\\n\\t<li>\\r\\n\\t<h4><strong>Features :</strong></h4>\\r\\n\\t</li>\\r\\n\\t<li>4 users on the control panel per branch</li>\\r\\n\\t<li>Four hours of training (online)</li>\\r\\n\\t<li>electronic billing support</li>\\r\\n\\t<li>Possibility of online and cash payments</li>\\r\\n\\t<li>Unlimited number of customers</li>\\r\\n\\t<li>Unlimited offers and coupons</li>\\r\\n\\t<li>Technical support 24/7</li>\\r\\n\\t<li>Unlimited number of sections and meals</li>\\r\\n\\t<li>Integrated authorization management system</li>\\r\\n\\t<li>10 day trial period</li>\\r\\n</ul>\"}', NULL, NULL, '2023-03-01 16:11:43', '2023-03-02 04:26:43', NULL),
(5, NULL, '{\"ar\": \"الباقه البلاتينية\", \"en\": \"Platinum package\"}', '{\"ar\": \"<ul><li><strong>منيو طلب ذاتي</strong></li><li><strong>عدد 1-10 فروع (99$ للفرع الواحد شهرياً)</strong></li></ul><h4><strong>الميزات :</strong></h4><ul><li>عدد 4 مستخدمين على لوحة التحكم لكل فرع</li><li>أربع ساعات تدريبية (أون لاين)</li><li>إمكانية دعم الفوترة الإلكترونية</li><li>إمكانية الدفع كاش و أون لاين</li><li>عدد لا محدود من العملاء</li><li>عدد لا محدود من العروض والكوبونات</li><li>الدعم الفني 24/7</li><li>عدد لا محدود من الأقسام والوجبات</li><li>نظام إدارة صلاحيات متكامل</li><li>مدة تجريبية 10 أيام</li></ul><p><br>&nbsp;</p>\", \"en\": \"<ul><li><strong>Self-order menu</strong></li><li><strong>1-10 branches ($99 per branch per month)</strong></li></ul><h4><strong>Features :</strong></h4><ul><li>4 users on the control panel per branch</li><li>Four hours of training (online)</li><li>electronic billing support</li><li>Possibility of online and cash payments</li><li>Unlimited number of customers</li><li>Unlimited offers and coupons</li><li>Technical support 24/7</li><li>Unlimited number of sections and meals</li><li>Integrated authorization management system</li><li>10 day trial period</li></ul>\"}', NULL, NULL, '2023-03-01 16:11:43', '2023-03-02 01:12:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` json NOT NULL,
  `body` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`key`, `title`, `body`, `created_at`, `updated_at`, `deleted_at`) VALUES
('about', '{\"ar\": \"من نحن\", \"en\": \"About us\"}', '{\"ar\": \"محتوي الصفحة فارغ حاليا\", \"en\": \"page content is empty\"}', NULL, NULL, NULL),
('privacy', '{\"ar\": \"سياسة الخصوصية\", \"en\": \"Privacy Policy\"}', '{\"ar\": \"محتوي الصفحة فارغ حاليا\", \"en\": \"page content is empty\"}', NULL, NULL, NULL),
('terms', '{\"ar\": \"القواعد والشروط\", \"en\": \"Terms and conditions\"}', '{\"ar\": \"محتوي الصفحة فارغ حاليا\", \"en\": \"page content is empty\"}', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `name_ar`, `name_en`, `created_at`, `updated_at`) VALUES
(1, 'view_admins', 'dashboard', 'عرض المدراء', 'view admins', NULL, NULL),
(2, 'create_admins', 'dashboard', 'إنشاء مدراء', 'create admins', NULL, NULL),
(3, 'update_admins', 'dashboard', 'تعديل المدراء', 'update admins', NULL, NULL),
(4, 'delete_admins', 'dashboard', 'حذف المدراء', 'delete admins', NULL, NULL),
(5, 'view_roles', 'dashboard', 'عرض الأدوار', 'view roles', NULL, NULL),
(6, 'create_roles', 'dashboard', 'إنشاء أدوار', 'create roles', NULL, NULL),
(7, 'update_roles', 'dashboard', 'تعديل الأدوار', 'update roles', NULL, NULL),
(8, 'delete_roles', 'dashboard', 'حذف الأدوار', 'delete roles', NULL, NULL),
(9, 'view_setting', 'dashboard', 'عرض الإعدادات', 'view setting', NULL, NULL),
(10, 'update_setting', 'dashboard', 'تغيير الإعدادات', 'update setting', NULL, NULL),
(11, 'view_contacts', 'dashboard', 'عرض جهات الاتصال', 'view contacts', NULL, NULL),
(12, 'view_notifications', 'dashboard', 'عرض الإشعارات', 'view notifications', NULL, NULL),
(13, 'create_packages', 'dashboard', 'إنشاء باقات', 'create packages', NULL, NULL),
(14, 'update_packages', 'dashboard', 'تعديل الباقات', 'update packages', NULL, NULL),
(15, 'delete_packages', 'dashboard', 'حذف الباقات', 'delete packages', NULL, NULL),
(16, 'view_packages', 'dashboard', 'عرض الباقات', 'view packages', NULL, NULL),
(17, 'create_homesections', 'dashboard', 'إنشاء أقسام الصفحة الرئيسية', 'create homesections', NULL, NULL),
(18, 'update_homesections', 'dashboard', 'تعديل أقسام الصفحة الرئيسية', 'update homesections', NULL, NULL),
(19, 'delete_homesections', 'dashboard', 'حذف أقسام الصفحة الرئيسية', 'delete homesections', NULL, NULL),
(20, 'view_homesections', 'dashboard', 'عرض أقسام الصفحة الرئيسية', 'view homesections', NULL, NULL),
(21, 'admin_profile', 'dashboard', 'صفحة الأدمن الشخصية', 'admin profile', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `reference_type`, `reference_id`, `created_at`, `updated_at`) VALUES
(1, 'super', 'dashboard', NULL, NULL, NULL, NULL),
(2, 'admin', 'dashboard', NULL, NULL, NULL, NULL),
(3, 'user', 'dashboard', NULL, NULL, NULL, NULL),
(4, 'ahmed role', 'dashboard', NULL, NULL, '2023-02-26 15:13:51', '2023-02-26 15:13:51');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(1, 4),
(3, 4),
(4, 4),
(5, 4),
(6, 4),
(7, 4),
(8, 4),
(9, 4),
(10, 4),
(11, 4),
(12, 4),
(13, 4),
(14, 4),
(15, 4),
(16, 4),
(17, 4),
(18, 4),
(19, 4),
(20, 4),
(21, 4);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name_ar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_name_en` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_api_key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name_ar`, `site_name_en`, `google_api_key`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'تطبيق', 'App', NULL, NULL, NULL, NULL, '2023-02-26 15:13:07', '2023-02-26 15:13:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `temporary_uploads`
--

CREATE TABLE `temporary_uploads` (
  `id` bigint UNSIGNED NOT NULL,
  `payload` json DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `deleted_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified_at` timestamp NULL DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `social_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `email`, `phone`, `phone_verified_at`, `email_verified_at`, `password`, `active`, `social_id`, `slug`, `created_by`, `updated_by`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super Admin', 'male', 'admin@admin.com', '96651010101010', NULL, NULL, '$2y$10$T5Hc71LQdN7H0dFUpJJPMeYdpW7G4d8mQaH.SsRn7Vke8BkszgCsa', '1', NULL, NULL, NULL, 1, 'tOTnUlyDSGK7KostUifhZKI78BsTLEzPJA2P8RCx4HlVgFcjtAgE9oKKkA6y', '2023-02-26 15:13:07', '2023-02-26 15:13:07', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by_type`,`created_by_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by_type`,`created_by_id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by_type`,`created_by_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `roles_reference_type_reference_id_index` (`reference_type`,`reference_id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temporary_uploads`
--
ALTER TABLE `temporary_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_slug_unique` (`slug`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `temporary_uploads`
--
ALTER TABLE `temporary_uploads`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
