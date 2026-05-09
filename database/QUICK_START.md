# Quick Start — البدء السريع

## إعداد قاعدة البيانات في 3 خطوات

### الخطوة 1: إنشاء قاعدة البيانات
```sql
CREATE DATABASE vana_hotel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### الخطوة 2: استيراد البنية
```bash
mysql -u root -p vana_hotel < database/schema.sql
```

### الخطوة 3: استيراد البيانات التجريبية
```bash
mysql -u root -p vana_hotel < database/seeder.sql
```

---

## بيانات الدخول

### لوحة الإدارة
```
Username: admin
Password: admin123
```

### المستخدمين
```
Email: ahmed@demo.com
Password: password123
```

---

## ✅ تم!

الآن يمكنك:
- تسجيل الدخول إلى لوحة الإدارة
- تصفح الغرف والحجوزات
- اختبار جميع الميزات

---

## 🔧 إعادة تعيين قاعدة البيانات

إذا أردت البدء من جديد:

```bash
mysql -u root -p -e "DROP DATABASE IF EXISTS vana_hotel;"
mysql -u root -p -e "CREATE DATABASE vana_hotel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p vana_hotel < database/schema.sql
mysql -u root -p vana_hotel < database/seeder.sql
```
