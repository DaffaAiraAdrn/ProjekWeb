-- ============================================================================
-- DF_137 Portfolio — Complete MySQL Schema & Seed Data
-- Database: df137_portfolio
-- Owner: Daffa Aira Adrin (DF_137)
-- Generated for Laravel 11 Portfolio CMS
-- ============================================================================

CREATE DATABASE IF NOT EXISTS `df137_portfolio` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `df137_portfolio`;

-- ----------------------------------------------------------------------------
-- Table: admins
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE INDEX `admins_email_unique` (`email`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table: portfolios
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `portfolios` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `category` ENUM('3D','ML','Programming') NOT NULL,
    `description` TEXT NULL DEFAULT NULL,
    `content` LONGTEXT NULL DEFAULT NULL,
    `thumbnail` VARCHAR(255) NULL DEFAULT NULL,
    `images` JSON NULL DEFAULT NULL,
    `featured` TINYINT(1) NOT NULL DEFAULT 0,
    `order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE INDEX `portfolios_slug_unique` (`slug`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table: blog_posts
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `excerpt` TEXT NULL DEFAULT NULL,
    `content` LONGTEXT NULL DEFAULT NULL,
    `featured_image` VARCHAR(255) NULL DEFAULT NULL,
    `tags` JSON NULL DEFAULT NULL,
    `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
    `published_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE INDEX `blog_posts_slug_unique` (`slug`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table: reports
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reports` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `abstract` LONGTEXT NULL DEFAULT NULL,
    `introduction` LONGTEXT NULL DEFAULT NULL,
    `methodology` LONGTEXT NULL DEFAULT NULL,
    `results` LONGTEXT NULL DEFAULT NULL,
    `conclusion` LONGTEXT NULL DEFAULT NULL,
    `references` LONGTEXT NULL DEFAULT NULL,
    `attachments` JSON NULL DEFAULT NULL,
    `cover_image` VARCHAR(255) NULL DEFAULT NULL,
    `status` ENUM('draft','published') NOT NULL DEFAULT 'draft',
    `published_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    UNIQUE INDEX `reports_slug_unique` (`slug`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table: contact_submissions
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_submissions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table: site_settings
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `key` VARCHAR(255) NOT NULL,
    `value` TEXT NULL DEFAULT NULL,
    UNIQUE INDEX `site_settings_key_unique` (`key`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table: media
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `media` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(255) NOT NULL,
    `original_name` VARCHAR(255) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `file_type` VARCHAR(255) NOT NULL,
    `file_size` BIGINT NOT NULL,
    `mime_type` VARCHAR(255) NULL DEFAULT NULL,
    `alt_text` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------------------------------------------------------
-- Table: migrations (Laravel migration tracking)
-- ----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- SEED DATA
-- ============================================================================

-- Admin user (password: ChangeMe123!)
INSERT INTO `admins` (`name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
('Daffa Aira Adrin', 'admin@df137.dev', NOW(), '$2b$12$vdlAcThwKBJXrpARYkrGeeqEQHsR/euuteJ.eng10zg.fqW/BRyze', NULL, NOW(), NOW());

-- Portfolios
INSERT INTO `portfolios` (`title`, `slug`, `category`, `description`, `content`, `thumbnail`, `images`, `featured`, `order`, `created_at`, `updated_at`) VALUES
(
    'Cyberpunk Mecha Robot — Blender 3D Sculpt',
    'cyberpunk-mecha-robot-blender-3d-sculpt',
    '3D',
    'A high-detail cyberpunk mecha robot model created in Blender 4.0 with Cycles rendering. Features PBR materials, intricate mechanical joints, and neon emissive accents.',
    '## Project Overview\n\nThis project showcases a fully rigged cyberpunk mecha robot designed in Blender 4.0. The model features over 500 individual parts, PBR (Physically Based Rendering) materials, and a complete rig for animation.\n\n## Process\n\n1. **Blockout & Silhouette** — Started with primitive shapes to establish the overall silhouette and proportions.\n2. **High-Poly Detailing** — Added mechanical joints, panel lines, and surface greebles using boolean operations and manual sculpting.\n3. **Retopology** — Created clean, animation-ready topology with quad-based meshes.\n4. **UV Unwrapping & Texturing** — Used Substance Painter for PBR texturing with metal, roughness, and emissive maps.\n5. **Lighting & Rendering** — Set up a three-point lighting rig with neon accent lights and rendered with Cycles at 4K resolution.\n\n## Tools Used\n\n- Blender 4.0 (Modeling, Rigging, Rendering)\n- Substance Painter (Texturing)\n- Krita (Concept Art)\n\n## Results\n\nThe final render achieved a photorealistic look with 2048 samples, denoising, and post-processing in Blender''s compositor. The model is fully rigged and ready for animation or game engine import.',
    NULL,
    JSON_ARRAY(),
    1,
    1,
    NOW(),
    NOW()
),
(
    'Image Classification with Convolutional Neural Networks',
    'image-classification-with-convolutional-neural-networks',
    'ML',
    'A deep learning project implementing CNN architecture for image classification on the CIFAR-10 dataset, achieving 92% test accuracy with data augmentation and transfer learning.',
    '## Project Overview\n\nThis project implements a Convolutional Neural Network (CNN) for image classification using the CIFAR-10 dataset. The model classifies images across 10 categories including airplanes, cars, birds, cats, and more.\n\n## Architecture\n\nThe CNN architecture consists of:\n- **Input Layer**: 32x32x3 RGB images\n- **Conv2D + ReLU + BatchNorm**: 3 convolutional blocks with increasing filter sizes (32, 64, 128)\n- **MaxPooling2D**: After each conv block for spatial reduction\n- **Dropout**: 0.25-0.5 for regularization\n- **Dense Layers**: 256 units with ReLU, followed by softmax output (10 classes)\n\n## Training Pipeline\n\n1. **Data Preprocessing**: Normalized pixel values to [0,1], applied one-hot encoding to labels.\n2. **Data Augmentation**: Random rotation (±15°), horizontal flip, width/height shift (±10%), zoom range (0.1).\n3. **Optimizer**: Adam with learning rate scheduling (ReduceLROnPlateau).\n4. **Loss Function**: Categorical crossentropy.\n5. **Batch Size**: 64, Epochs: 50 with early stopping (patience=10).\n\n## Results\n\n- **Training Accuracy**: 94.7%\n- **Validation Accuracy**: 92.3%\n- **Test Accuracy**: 92.1%\n- **Training Time**: ~3 hours on NVIDIA RTX 3060\n\n## Key Learnings\n\n- Batch normalization significantly sped up convergence.\n- Data augmentation reduced overfitting by ~8%.\n- Transfer learning with ResNet50 backbone pushed accuracy to 95.4%.',
    NULL,
    JSON_ARRAY(),
    1,
    2,
    NOW(),
    NOW()
),
(
    'Real-Time Chat Application with Laravel & WebSocket',
    'real-time-chat-application-with-laravel-and-websocket',
    'Programming',
    'A full-stack real-time chat application built with Laravel 11, Laravel Reverb for WebSocket communication, and a responsive Vue.js frontend. Supports private rooms, typing indicators, and message history.',
    '## Project Overview\n\nA real-time chat application supporting multiple chat rooms, private messaging, typing indicators, and online user presence. Built with Laravel 11 backend and Vue 3 frontend.\n\n## Features\n\n- **Real-time messaging** via Laravel Reverb (WebSocket server)\n- **Multiple chat rooms** with public and private options\n- **Typing indicators** showing when users are composing messages\n- **Online presence** tracking with heartbeat mechanism\n- **Message history** with pagination and search\n- **File sharing** support for images and documents\n- **Read receipts** for private messages\n- **Responsive design** works on desktop and mobile\n\n## Tech Stack\n\n- **Backend**: Laravel 11, Laravel Reverb, Laravel Echo\n- **Frontend**: Vue 3 (Composition API), Tailwind CSS\n- **Database**: MySQL 8.0\n- **Authentication**: Laravel Sanctum (SPA auth)\n- **Deployment**: Docker with Nginx reverse proxy\n\n## Architecture\n\nThe application uses an event-driven architecture:\n1. Client sends message via HTTP POST to Laravel API.\n2. Laravel broadcasts a `MessageSent` event through Reverb.\n3. Laravel Echo on the client listens for the event and updates the UI in real-time.\n4. Presence channel tracks online users via join/leave events.\n\n## Challenges & Solutions\n\n- **WebSocket scaling**: Used Redis adapter for horizontal scaling.\n- **Message ordering**: Implemented sequence numbers per room.\n- **Offline message sync**: Stored all messages in DB and synced on reconnect.',
    NULL,
    JSON_ARRAY(),
    1,
    3,
    NOW(),
    NOW()
);

-- Blog Posts
INSERT INTO `blog_posts` (`title`, `slug`, `excerpt`, `content`, `featured_image`, `tags`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(
    'Getting Started with 3D Modeling in Blender: A Beginner''s Guide',
    'getting-started-with-3d-modeling-in-blender-a-beginners-guide',
    'Everything you need to know to start your 3D modeling journey with Blender — from interface navigation to your first render.',
    '# Getting Started with 3D Modeling in Blender\n\nBlender is a free, open-source 3D creation suite that has become the industry standard for independent 3D artists. In this guide, I will walk you through the essentials to get you modeling in no time.\n\n## 1. Understanding the Interface\n\nWhen you first open Blender, the interface can feel overwhelming. Here are the key areas:\n\n- **Viewport**: The 3D space where you see and manipulate your model.\n- **Outliner**: Shows the hierarchy of all objects in your scene.\n- **Properties Panel**: Where you adjust object properties, materials, and render settings.\n- **Timeline**: For animation keyframes.\n\n## 2. Navigation\n\n- **Middle Mouse Button (MMB)**: Orbit around the scene.\n- **Shift + MMB**: Pan the view.\n- **Scroll Wheel**: Zoom in and out.\n- **Numpad 0**: Camera view.\n- **Numpad 1/3/7**: Front/right/top orthographic views.\n\n## 3. Your First Model\n\nStart with something simple — a coffee mug:\n\n1. Add a cylinder (Shift + A > Mesh > Cylinder).\n2. Enter Edit Mode (Tab).\n3. Select the top face, inset it (I), and extrude downward (E) to create the hollow interior.\n4. Add a handle using a torus or by extruding a face curve.\n5. Apply a material with the Principled BSDF shader.\n\n## 4. Lighting and Rendering\n\nSet up a three-point lighting rig:\n- **Key Light**: Main light source at 45° from the camera.\n- **Fill Light**: Softer light on the opposite side to reduce harsh shadows.\n- **Rim Light**: Behind the subject to create edge separation.\n\nSwitch to Cycles render engine for photorealistic results, or use Eevee for real-time preview.\n\n## Next Steps\n\nOnce you are comfortable with the basics, explore sculpting, UV mapping, and texturing. The Blender community is incredibly supportive — check out Blender Guru, Grant Abbitt, and CG Cookie for excellent tutorials.',
    NULL,
    JSON_ARRAY('Blender', '3D Modeling', 'Tutorial', 'Beginner'),
    'published',
    DATE_SUB(NOW(), INTERVAL 10 DAY),
    NOW(),
    NOW()
),
(
    'Understanding Convolutional Neural Networks: From Pixels to Predictions',
    'understanding-convolutional-neural-networks-from-pixels-to-predictions',
    'A deep dive into how CNNs process images, from convolution operations to pooling layers and fully connected networks.',
    '# Understanding Convolutional Neural Networks\n\nConvolutional Neural Networks (CNNs) are the backbone of modern computer vision. They have revolutionized image classification, object detection, and facial recognition.\n\n## What is a Convolution?\n\nA convolution is a mathematical operation that slides a small filter (kernel) over an image and computes the dot product at each position. This allows the network to detect features like edges, corners, and textures.\n\n### How It Works\n\nImagine a 3x3 filter sliding across a 5x5 image:\n\n```\nImage:          Filter:     Output:\n[1 0 1 0 1]    [1 0 1]    [4 3 4]\n[0 1 0 1 0]  x [0 1 0]  = [3 4 3]\n[1 0 1 0 1]    [1 0 1]    [4 3 4]\n[0 1 0 1 0]\n[1 0 1 0 1]\n```\n\nEach position in the output is the sum of element-wise multiplication between the filter and the corresponding image patch.\n\n## Pooling Layers\n\nPooling reduces the spatial dimensions of the feature maps, which:\n- Reduces computational load\n- Provides translation invariance\n- Controls overfitting\n\n**Max Pooling** takes the maximum value in each window, while **Average Pooling** takes the average.\n\n## Architecture of a Typical CNN\n\n1. **Conv Layer** → Extract low-level features (edges, corners)\n2. **Conv Layer** → Extract mid-level features (textures, patterns)\n3. **Pooling** → Reduce spatial dimensions\n4. **Conv Layer** → Extract high-level features (object parts)\n5. **Pooling** → Further reduction\n6. **Flatten** → Convert 2D features to 1D vector\n7. **Dense Layer** → Combine features for classification\n8. **Softmax** → Output probability distribution\n\n## Why CNNs Work\n\nCNNs leverage three key principles:\n\n- **Local Connectivity**: Each neuron only connects to a small region, mimicking how human visual cortex works.\n- **Weight Sharing**: The same filter is applied across the entire image, dramatically reducing parameters.\n- **Hierarchical Features**: Lower layers learn simple features, higher layers combine them into complex patterns.\n\n## Practical Tips\n\n- Start with a simple architecture before going deep.\n- Always normalize your input data.\n- Use data augmentation to improve generalization.\n- Monitor for overfitting with validation data.\n- Experiment with transfer learning using pre-trained models like ResNet or VGG.',
    NULL,
    JSON_ARRAY('Machine Learning', 'CNN', 'Deep Learning', 'Computer Vision'),
    'published',
    DATE_SUB(NOW(), INTERVAL 5 DAY),
    NOW(),
    NOW()
);

-- Report
INSERT INTO `reports` (`title`, `slug`, `abstract`, `introduction`, `methodology`, `results`, `conclusion`, `references`, `attachments`, `cover_image`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(
    'Comparative Analysis of Deep Learning Architectures for Image-Based Plant Disease Detection',
    'comparative-analysis-of-deep-learning-architectures-for-image-based-plant-disease-detection',
    'This report presents a comparative analysis of three deep learning architectures — Convolutional Neural Networks (CNN), Residual Networks (ResNet-50), and Vision Transformers (ViT) — applied to the task of plant disease detection from leaf images. The study evaluates model performance on the PlantVillage dataset containing 54,306 images across 14 crop species and 26 diseases. Results demonstrate that the ViT model achieves the highest classification accuracy of 97.8%, outperforming ResNet-50 (96.2%) and the custom CNN (93.5%). The findings suggest that attention-based architectures offer superior feature extraction capabilities for fine-grained visual classification tasks in agricultural applications.',
    '## 1. Introduction\n\nPlant diseases pose a significant threat to global food security, causing annual crop losses estimated at 16% worldwide [1]. Early and accurate detection of plant diseases is critical for effective disease management and reducing agricultural losses. Traditional methods rely on manual inspection by trained experts, which is time-consuming, labor-intensive, and prone to human error.\n\nRecent advances in deep learning have enabled automated plant disease detection systems that can classify diseases from leaf images with high accuracy. However, the choice of architecture significantly impacts performance, computational cost, and deployment feasibility.\n\n### 1.1 Research Objectives\n\nThis study aims to:\n1. Implement and compare three deep learning architectures for plant disease classification.\n2. Evaluate performance metrics including accuracy, precision, recall, and F1-score.\n3. Analyze computational efficiency and inference time for each model.\n4. Provide recommendations for architecture selection in real-world agricultural deployments.\n\n### 1.2 Scope\n\nThe study focuses on classification of plant diseases from single leaf images. It does not address real-time field deployment, multi-leaf detection, or disease severity grading.',
    '## 2. Methodology\n\n### 2.1 Dataset\n\nThe PlantVillage dataset was used, containing 54,306 leaf images across 14 crop species and 26 diseases (including healthy samples). The dataset was split into 70% training (38,014 images), 15% validation (8,146 images), and 15% testing (8,146 images).\n\n### 2.2 Preprocessing\n\n- Images resized to 224x224 pixels for all models.\n- Pixel values normalized to [0, 1].\n- Data augmentation applied: random rotation (±30°), horizontal/vertical flip, color jitter (brightness ±0.2, contrast ±0.2).\n\n### 2.3 Model Architectures\n\n#### 2.3.1 Custom CNN\n\nA 6-layer CNN with:\n- 3 convolutional blocks (32, 64, 128 filters) with 3x3 kernels, ReLU activation, batch normalization.\n- Max pooling (2x2) after each block.\n- Dropout (0.5) before dense layers.\n- Dense layer (256, ReLU) → Softmax (26 classes).\n\n#### 2.3.2 ResNet-50 (Transfer Learning)\n\nPre-trained ResNet-50 on ImageNet with:\n- Frozen base layers (first 80%).\n- Custom classification head: GlobalAveragePooling2D → Dense(256, ReLU) → Dropout(0.5) → Softmax(26).\n- Fine-tuning of top 20% layers with learning rate 1e-5.\n\n#### 2.3.3 Vision Transformer (ViT-B/16)\n\nPre-trained ViT-B/16 from Google with:\n- Patch size: 16x16 (196 patches per image).\n- 12 transformer layers, 768 hidden size, 12 attention heads.\n- Custom classification head: LayerNorm → Linear(256) → GELU → Dropout(0.1) → Linear(26).\n- Fine-tuning all layers with learning rate 1e-4 and warmup schedule.\n\n### 2.4 Training Configuration\n\n- Optimizer: AdamW with weight decay 0.01.\n- Learning rate: 1e-3 (CNN), 1e-5 (ResNet-50), 1e-4 (ViT) with cosine annealing.\n- Batch size: 32.\n- Epochs: 50 with early stopping (patience=10).\n- Loss function: Categorical crossentropy.\n- Hardware: NVIDIA RTX 3090 (24GB VRAM).\n\n### 2.5 Evaluation Metrics\n\n- Overall accuracy.\n- Per-class precision, recall, and F1-score.\n- Confusion matrix analysis.\n- Inference time per image (ms).\n- Model size (parameters and MB).',
    '## 3. Results\n\n### 3.1 Classification Performance\n\n| Model | Accuracy | Precision | Recall | F1-Score |\n|-------|----------|-----------|--------|----------|\n| Custom CNN | 93.5% | 93.2% | 93.1% | 93.1% |\n| ResNet-50 | 96.2% | 96.0% | 95.9% | 95.9% |\n| ViT-B/16 | 97.8% | 97.6% | 97.5% | 97.5% |\n\n### 3.2 Computational Efficiency\n\n| Model | Parameters | Model Size | Inference Time | Training Time |\n|-------|-----------|-----------|----------------|---------------|\n| Custom CNN | 1.2M | 4.8 MB | 8.3 ms | 2.5 hours |\n| ResNet-50 | 23.5M | 94.1 MB | 15.7 ms | 6.8 hours |\n| ViT-B/16 | 85.8M | 343.2 MB | 22.1 ms | 12.4 hours |\n\n### 3.3 Analysis\n\nThe ViT-B/16 model achieved the highest accuracy (97.8%), outperforming ResNet-50 by 1.6% and the custom CNN by 4.3%. The superior performance of ViT can be attributed to its self-attention mechanism, which captures global relationships between image patches more effectively than the local receptive fields of CNNs.\n\nHowever, this performance comes at a cost: ViT has 3.6x more parameters than ResNet-50 and 71.5x more than the custom CNN. Inference time for ViT is also 2.7x slower than the custom CNN.\n\nThe custom CNN, while having the lowest accuracy, offers the best trade-off between performance and efficiency for resource-constrained deployment scenarios (e.g., mobile devices, edge computing).\n\n### 3.4 Per-Class Analysis\n\nThe most challenging classes for all models were diseases with similar visual symptoms:\n- Tomato Early Blight vs. Tomato Late Blight (ViT: 94.2%, CNN: 82.1%).\n- Apple Scab vs. Apple Cedar Rust (ViT: 96.1%, CNN: 85.3%).\n\nViT showed significantly better performance on these confusable pairs, suggesting that attention mechanisms are better at capturing subtle visual differences.',
    '## 4. Conclusion\n\nThis study compared three deep learning architectures for plant disease detection from leaf images. The key findings are:\n\n1. **ViT-B/16** achieved the highest accuracy (97.8%) and F1-score (97.5%), demonstrating the effectiveness of attention-based architectures for fine-grained visual classification.\n2. **ResNet-50** with transfer learning provided a strong balance between accuracy (96.2%) and computational cost, making it suitable for server-side deployment.\n3. **Custom CNN** offered the best efficiency with 93.5% accuracy and only 4.8 MB model size, making it ideal for edge and mobile deployment.\n\n### 4.1 Recommendations\n\n- For **maximum accuracy** in server environments: Use ViT-B/16.\n- For **balanced performance**: Use ResNet-50 with transfer learning.\n- For **edge/mobile deployment**: Use a lightweight custom CNN.\n\n### 4.2 Future Work\n\n- Explore lightweight attention mechanisms (e.g., MobileViT) for edge deployment.\n- Investigate multi-modal fusion combining leaf images with environmental data (temperature, humidity).\n- Develop a real-time field deployment system with mobile app integration.\n- Test on additional datasets with more diverse lighting and background conditions.',
    '[1] Savary, S., Willocquet, L., Pethybridge, S. J., et al. (2019). The global burden of pathogens and pests on major food crops. Nature Ecology & Evolution, 3(3), 430-439.\n\n[2] Mohanty, S. P., Hughes, D. P., & Salathé, M. (2016). Using deep learning for image-based plant disease detection. Frontiers in Plant Science, 7, 1419.\n\n[3] He, K., Zhang, X., Ren, S., & Sun, J. (2016). Deep residual learning for image recognition. In Proceedings of the IEEE Conference on Computer Vision and Pattern Recognition (pp. 770-778).\n\n[4] Dosovitskiy, A., Beyer, L., Kolesnikov, A., et al. (2021). An image is worth 16x16 words: Transformers for image recognition at scale. In International Conference on Learning Representations (ICLR).\n\n[5] Hughes, D., & Salathé, M. (2015). An open access repository of images on plant health to enable the development of mobile disease diagnostics. arXiv preprint arXiv:1511.08060.\n\n[6] Ferentinos, K. P. (2018). Deep learning models for plant disease detection and diagnosis. Computers and Electronics in Agriculture, 145, 311-318.\n\n[7] Picon, A., Seitz, M., Alvarez-Gila, A., et al. (2019). Crop conditional convolutional neural networks for massive multi-crop disease classification over geographically dispersed test data. Computers and Electronics in Agriculture, 167, 105043.\n\n[8] Liu, B., Zhang, Y., He, D., et al. (2018). Identification of apple leaf diseases based on deep convolutional neural networks. Symmetry, 10(1), 11.\n\n[9] Too, E. C., Yujian, L., Njuki, S., & Yingchun, L. (2019). A comparative study of fine-tuning deep learning models for plant disease identification. Computers and Electronics in Agriculture, 161, 214-225.\n\n[10] Touvron, H., Cord, M., Douze, M., et al. (2021). Training data-efficient image transformers & distillation through attention. In International Conference on Machine Learning (ICML).',
    JSON_ARRAY(),
    NULL,
    'published',
    DATE_SUB(NOW(), INTERVAL 2 DAY),
    NOW(),
    NOW()
);

-- Site Settings
INSERT INTO `site_settings` (`key`, `value`) VALUES
('site_name', 'DF_137 Portfolio'),
('owner_name', 'Daffa Aira Adrin'),
('owner_tagline', 'Informatics Student | 3D Modeling · Machine Learning · Programming'),
('owner_bio', 'I am Daffa Aira Adrin (DF_137), an Informatics student with a deep passion for technology and creativity. My journey spans three interconnected worlds: 3D modeling, where I bring imagination to life through digital sculpting in Blender; machine learning, where I explore the frontiers of artificial intelligence and deep learning; and programming, where I build practical solutions that solve real-world problems.\n\nI believe that the intersection of art and technology is where innovation happens. Whether I am training neural networks, sculpting cyberpunk mechas, or architecting web applications, I am always pushing the boundaries of what I can create.'),
('github_url', 'https://github.com/DaffaAiraAdrn'),
('youtube_url', 'https://youtube.com/@360hz4'),
('instagram_url', 'https://instagram.com/df__137'),
('contact_email', '2411531006_daffa@unand.ac.id'),
('footer_text', '© 2024 Daffa Aira Adrin (DF_137). Crafted with passion for 3D, ML, and Code.'),
('hero_title', 'Where Creativity Meets Technology'),
('hero_subtitle', '3D Modeling · Machine Learning · Programming'),
('about_title', 'About Me'),
('about_subtitle', 'Informatics student exploring the intersection of art and technology');

-- Sample contact submission
INSERT INTO `contact_submissions` (`name`, `email`, `subject`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
('John Doe', 'john.doe@example.com', 'Collaboration Inquiry', 'Hi Daffa, I came across your portfolio and was impressed by your 3D modeling work. I am working on a game project and would love to collaborate on some character models. Let me know if you are interested!', 0, NOW(), NOW());

-- Sample media entry
INSERT INTO `media` (`filename`, `original_name`, `file_path`, `file_type`, `file_size`, `mime_type`, `alt_text`, `created_at`, `updated_at`) VALUES
('sample_placeholder.jpg', 'sample_placeholder.jpg', 'uploads/media/sample_placeholder.jpg', 'jpg', 0, 'image/jpeg', 'Sample placeholder image', NOW(), NOW());

-- Migration tracking
INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2024_01_01_000001_create_admins_table', 1),
('2024_01_01_000002_create_portfolios_table', 1),
('2024_01_01_000003_create_blog_posts_table', 1),
('2024_01_01_000004_create_reports_table', 1),
('2024_01_01_000005_create_contact_submissions_table', 1),
('2024_01_01_000006_create_site_settings_table', 1),
('2024_01_01_000007_create_media_table', 1);

-- ============================================================================
-- END OF SCHEMA
-- ============================================================================
