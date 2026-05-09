# 📦 أرشيف ملفات قاعدة البيانات القديمة
# Database Archive - Old SQL Files

## ℹ️ معلومات

هذا المجلد يحتوي على ملفات SQL القديمة التي تم دمجها في `install.sql`.

**الملفات القديمة موجودة هنا للمرجع فقط.**

---

## 📁 الملفات المؤرشفة

### ملفات SQL القديمة (تم دمجها):
1. ✅ `schema.sql` - البنية الأساسية (17 جدول)
2. ✅ `seeder.sql` - البيانات التجريبية
3. ✅ `schema_translations.sql` - جداول الترجمة (3 جداول)
4. ✅ `seeder_translations.sql` - بيانات الترجمة (72 سجل)
5. ✅ `m_hotel.sql` - الملف القديم الأصلي

### ملفات أخرى:
- `README_OLD.md` - نسخة قديمة من README

---

## ⚠️ تنبيه مهم

**لا تستخدم هذه الملفات للتثبيت!**

استخدم الملف الجديد بدلاً منها:
```bash
mysql -u root -p homework_std_ro_db < database/install.sql
```

---

## 🔄 لماذا تم الأرشفة؟

تم دمج هذه الملفات الأربعة في ملف واحد شامل (`install.sql`) لتسهيل التثبيت:

### قبل (4 أوامر):
```bash
mysql -u root -p homework_std_ro_db < database/schema.sql
mysql -u root -p homework_std_ro_db < database/seeder.sql
mysql -u root -p homework_std_ro_db < database/schema_translations.sql
mysql -u root -p homework_std_ro_db < database/seeder_translations.sql
```

### بعد (أمر واحد) ⭐:
```bash
mysql -u root -p homework_std_ro_db < database/install.sql
```

---

## 📝 متى تستخدم الملفات المؤرشفة؟

يمكنك استخدام هذه الملفات إذا:
- أردت فهم كيف تم بناء قاعدة البيانات خطوة بخطوة
- تحتاج لتثبيت جزء معين فقط (مثلاً: البنية فقط بدون البيانات)
- تريد مقارنة التغييرات بين الإصدارات

---

## 🗑️ هل يمكن حذف هذا المجلد؟

نعم، يمكنك حذف هذا المجلد بالكامل إذا أردت. الملف `install.sql` يحتوي على كل شيء.

لكن نوصي بالاحتفاظ به للمرجع.

---

## 📚 الملفات الحالية المستخدمة

الملفات التي يجب استخدامها الآن:

```
database/
├── install.sql          ⭐ الملف الرئيسي للتثبيت
├── INSTALL.md           📖 دليل التثبيت السريع
├── README.md            📖 الوثائق الرئيسية
├── TRANSLATIONS_README.md  📖 دليل نظام الترجمة
└── archive/             📦 الملفات القديمة (هذا المجلد)
```

---

**تاريخ الأرشفة**: 2026-05-09  
**السبب**: دمج الملفات في `install.sql`  
**الحالة**: ✅ مؤرشف (للمرجع فقط)
