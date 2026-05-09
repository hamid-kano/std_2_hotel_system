# Database Files

## Files

| File | Description |
|------|-------------|
| `../m_hotel.sql` | Schema + original data (import first) |
| `seeder.sql` | Clean demo data for testing |

## How to use

### Option 1 — phpMyAdmin
1. Import `m_hotel.sql` to create the database
2. Run `seeder.sql` to populate with demo data

### Option 2 — Command line
```bash
mysql -u root -p homework_std_ro_db < m_hotel.sql
mysql -u root -p homework_std_ro_db < database/seeder.sql
```

## Demo Credentials

### Admin
| Field | Value |
|-------|-------|
| Username | `admin` |
| Password | `admin123` |

### Users (all use password: `password123`)
| Name | Email |
|------|-------|
| Ahmed Ali | ahmed@demo.com |
| Sara Hassan | sara@demo.com |
| Omar Khalid | omar@demo.com |
| Layla Nouri | layla@demo.com |
| Karwan Aziz | karwan@demo.com |

## Demo Data Summary

| Table | Records |
|-------|---------|
| Rooms | 6 (Standard → Presidential Suite) |
| Features | 10 |
| Facilities | 8 |
| Users | 5 |
| Bookings | 9 (completed, active, cancelled) |
| Reviews | 5 (ratings 3–5 stars) |
| Queries | 5 (mix of seen/unseen) |
| Team Members | 4 |
| Carousel | 3 images |

## Notes
- The seeder **truncates all tables** before inserting — run only on a fresh/test database
- Room images reference files already in `public/images/rooms/`
- Balances are pre-loaded so users can make bookings immediately
