<div align="center">

# WINX98 🎰

### *Unleash Winning Potential, Elevate Every Moment*

[![Last Commit](https://img.shields.io/github/last-commit/vestearth/winx98?style=flat-square&color=00d4aa)](https://github.com/vestearth/winx98/commits)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Languages](https://img.shields.io/github/languages/count/vestearth/winx98?style=flat-square&color=ff6b6b)](https://github.com/vestearth/winx98)
[![License](https://img.shields.io/badge/License-Proprietary-red?style=flat-square)](LICENSE)

**Built with the tools and technologies:**

![JSON](https://img.shields.io/badge/JSON-000000?style=flat-square&logo=json&logoColor=white)
![Markdown](https://img.shields.io/badge/Markdown-000000?style=flat-square&logo=markdown&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat-square&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)

</div>

---

## 📚 Table of Contents

- [🎯 Overview](#-overview)
- [🚀 Getting Started](#-getting-started)
- [📋 Prerequisites](#-prerequisites)
- [⚙️ Installation](#️-installation)
- [🎮 Usage](#-usage)
- [🧪 Testing](#-testing)
- [🏗️ Architecture](#️-architecture)
- [🎨 Features](#-features)
- [🔧 Configuration](#-configuration)
- [📱 API Reference](#-api-reference)
- [🤝 Contributing](#-contributing)
- [📄 License](#-license)

---

## 🎯 Overview

WINX98 is a comprehensive gaming platform that delivers an immersive online casino experience. Built with modern web technologies and a robust PHP backend, it offers a wide variety of games including slots, live casino, sports betting, and more.

### ✨ Key Highlights

- 🎰 **Multi-Game Platform** - Slots, Casino Live, Sports, Cards, Fishing & More
- 🌍 **Multi-Language Support** - Internationalization ready
- 📱 **Mobile Responsive** - Optimized for all devices
- 🔐 **Secure Authentication** - OTP verification & user management
- 💰 **Banking Integration** - Multiple payment methods
- 📊 **Real-time Analytics** - Comprehensive reporting system

---

## 🚀 Getting Started

### Quick Start
```bash
# Clone the repository
git clone https://github.com/vestearth/winx98.git
cd winx98

# Set up your web server
# Configure database connection
# Launch the application
```

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.0+** with extensions:
  - mysqli/pdo_mysql
  - curl
  - json
  - mbstring
- **MySQL 5.7+** or **MariaDB 10.3+**
- **Web Server** (Apache/Nginx)
- **Composer** (optional, for dependencies)

### System Requirements
- **RAM**: Minimum 2GB
- **Storage**: At least 1GB free space
- **Bandwidth**: Stable internet connection for game providers

---

## ⚙️ Installation

### 1. Environment Setup
```bash
# Clone and navigate
git clone https://github.com/vestearth/winx98.git
cd winx98

# Set permissions
chmod -R 755 .
chmod -R 777 uploads/ logs/ cache/
```

### 2. Database Configuration
```sql
-- Create database
CREATE DATABASE winx98_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Import schema (if available)
mysql -u username -p winx98_db < database/schema.sql
```

### 3. Application Configuration
```php
// Configure in .framework/config/database.php
$config = [
    'host' => 'localhost',
    'database' => 'winx98_db',
    'username' => 'your_username',
    'password' => 'your_password'
];
```

---

## 🎮 Usage

### User Features

#### 🔐 Authentication System
- **Registration**: Phone-based signup with OTP verification
- **Login**: Secure user authentication
- **Profile Management**: Complete user profile system

#### 🎯 Gaming Experience
```php
// Game types available
$gameTypes = [
    'SLOT' => 'Slot Machines',
    'CASINOLIVE' => 'Live Casino',
    'SPORTBOOK' => 'Sports Betting',
    'FISHING' => 'Fishing Games',
    'CARD' => 'Card Games',
    'LOTTO' => 'Lottery',
    'ARCADE' => 'Arcade Games'
];
```

#### 💰 Banking Operations
- Deposit funds via multiple payment methods
- Withdraw winnings securely
- Transaction history tracking

### Admin Features

#### 📊 Management Dashboard
- User management and monitoring
- Game configuration and settings
- Financial reports and analytics
- Alliance management system

---

## 🧪 Testing

### Frontend Testing
```bash
# Test responsive design
# Verify cross-browser compatibility
# Check mobile functionality
```

### Backend Testing
```php
// Test database connections
// Verify API endpoints
// Check security measures
```

---

## 🏗️ Architecture

### Project Structure
```
winx98/
├── 🏗️ .framework/           # Custom PHP framework
├── 🎨 assets/              # Frontend assets
│   ├── css/               # Stylesheets & themes
│   ├── js/                # JavaScript modules
│   └── images/            # Game assets & UI
├── 🖼️ layout/              # Reusable components
├── 👁️ view/                # Page templates
├── 🔧 wloves/module/       # Modular system
├── 🆕 new_design/          # Modern UI assets
├── 🎮 games.php            # Game catalog
├── 👤 user.php             # User dashboard
└── 🔐 login.php            # Authentication
```

### Technology Stack

| Layer | Technology | Purpose |
|-------|------------|---------|
| **Frontend** | HTML5, CSS3, JavaScript | User interface & experience |
| **Backend** | PHP 8.0+, Custom Framework | Server-side logic |
| **Database** | MySQL/MariaDB | Data persistence |
| **Styling** | Custom CSS Framework | Responsive design |
| **Authentication** | OTP System | Secure user verification |

---

## 🎨 Features

### 🎰 Gaming Platform
- **Slot Games**: Various themed slot machines
- **Live Casino**: Real-time dealer games
- **Sports Betting**: Comprehensive sportsbook
- **Card Games**: Traditional and modern card games
- **Fishing Games**: Interactive arcade-style games
- **Lottery System**: Number-based gaming

### 🔐 Security & Authentication
- Multi-factor authentication with OTP
- Secure password handling
- SQL injection protection
- CSRF token validation
- Session management

### 💰 Financial System
- Multi-currency support
- Secure payment processing
- Real-time transaction tracking
- Automated withdrawal system
- Comprehensive financial reporting

### 📱 User Experience
- Responsive mobile design
- Multi-language interface
- Real-time notifications
- Intuitive navigation
- Accessibility features

---

## 🔧 Configuration

### Game Provider Setup
```php
// Configure game providers in games.php
$gameProviders = [
    'slots' => ['provider1', 'provider2'],
    'live_casino' => ['evolution', 'pragmatic'],
    'sports' => ['sportsbook_provider']
];
```

### Payment Gateway Integration
```php
// Payment methods configuration
$paymentMethods = [
    'bank_transfer' => true,
    'e_wallet' => true,
    'cryptocurrency' => false
];
```

---

## 📱 API Reference

### Authentication Endpoints
```http
POST /api/auth/login
POST /api/auth/register
POST /api/auth/verify-otp
```

### Game Management
```http
GET /api/games/list
GET /api/games/launch/{gameId}
POST /api/games/bet
```

### User Management
```http
GET /api/user/profile
PUT /api/user/update
GET /api/user/transactions
```

---

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/amazing-feature`)
3. **Commit** your changes (`git commit -m 'Add amazing feature'`)
4. **Push** to the branch (`git push origin feature/amazing-feature`)
5. **Open** a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation

---

## 📄 License

This project is **proprietary software**. All rights reserved.

```
Copyright (c) 2024 VestEarth
Unauthorized copying, distribution, or modification is prohibited.
```

---

<div align="center">

**🎰 WINX98 - Where Every Spin Counts! 🎰**

[![GitHub](https://img.shields.io/badge/GitHub-vestearth-181717?style=flat-square&logo=github)](https://github.com/vestearth)

*Built with ❤️ for the gaming community*

</div>
