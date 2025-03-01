# WordPress Popup Plugin

## Overview
This is a custom WordPress plugin that creates and manages popups using **OOP principles**, **WordPress Custom Post Types (CPT)**, and a **Vue.js frontend**. The plugin follows best practices by implementing **namespaces, traits, interfaces, the Singleton pattern, and custom REST API authentication** to ensure secure access.

## Features
- Built using **WP Scaffold Plugin** as the foundation for better structure.
- **OOP Structure** with PHP namespaces, traits, and interfaces.
- Implements the **Singleton Pattern** for efficient memory management.
- Uses **WordPress CPT & Custom Fields** (without external plugins) to store popups.
- Designed with **SASS** for better styling and maintainability.
- Uses **Vue.js** to display the popup dynamically.
- Provides a secure **REST API** endpoint (`/wp-json/artistudio/v1/popups`) that allows access **only for logged-in users** (temporarily commented out due to issues).

---

### Installation Steps
#### **Step 1: Clone the Repository**
Navigate to your WordPress plugins directory and clone the repository:
```sh
cd wp-content/plugins
git clone https://github.com/cuncis/artistudio-popup.git
cd artistudio-popup
```

#### **Step 2: Activate the Plugin**
1. Go to **WordPress Admin > Plugins**.
2. find **Artistudio Popup**.
3. click **Activate**.

---

OR

#### **Step 1: Download ZIP Repository**
```sh
Go to https://github.com/cuncis/artistudio-popup.git
Download ZIP
```

#### **Step 2: Activate the Plugin**
1. Navigate to **Plugins > Add New**.
2. Click **Upload Plugin**.
3. Select the **artistudio-popup.zip** file.
4. Click **Install Now**.
5. Then **Activate the plugin** after installation.


## Usage Guide

### ** Adding a New Popup**
1. Go to **Admin > Popups > Add New**.
2. Fill in the **Title** and **Description**.
3. Select the **Page** where the popup should appear.
4. Publish the popup.


## How the Popup Works
1. Once a popup is published and assigned to a page, visit that page.
2. The page will load normally, and after **2 seconds**, the popup will appear.
3. The user can close the popup using a close button.


## 🚀 Contributing
Feel free to submit pull requests, report bugs, or suggest improvements via GitHub!

---

## 📜 License
This project is licensed under the **MIT License**.

