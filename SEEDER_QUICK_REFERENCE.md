# Seeder & Data Management - Quick Reference

## 🚀 Quick Start

### Access the Feature
Navigate to: **Admin Dashboard → Seeder & Data Management**  
Or directly: `http://your-site/admin/seeders`

## 📋 Seeder Buttons (Available Seeders)

Run these to populate your database with sample data:

| Seeder | Purpose | Tables Affected |
|--------|---------|-----------------|
| 🎓 **Enrollment Data** | Student enrollment across colleges | `enrollments`, `staff`, `colleges` |
| 👔 **Staff/Employee Data** | Staff and employee statistics | `staff` |
| 📢 **Announcements** | Sample announcements | `announcements` |
| 📚 **Programs & Colleges** | Academic programs and colleges | `programs`, `colleges` |
| 🏆 **Accomplishment Reports** | GAD accomplishment data | `accomplishment_reports` |
| 📊 **GAD KPI Data** | Key performance indicators | GAD KPI tables |
| 📈 **Statistics** | Student/employee statistics | `student_statistics`, `employee_statistics` |

## 🗑️ Wipe Data Buttons (Clean Up by Section)

Delete data from specific sections with individual buttons:

| Section | Deletes | Use Case |
|---------|---------|----------|
| 📊 **Statistics** | Student/employee stats | Reset stats data |
| 🖼️ **Banners** | Page banners | Clean up banners |
| 🏆 **Accomplishment Reports** | GAD reports | Reset accomplishments |
| 📈 **Charts** | Chart configs | Reset chart configs |
| 📢 **Announcements** | All announcements | Clean announcements |
| 👥 **Organization Members** | Org structure | Reset org members |
| 📚 **Programs** | All programs | Clear programs |
| 📄 **Documents** | All documents | Remove documents |
| 📋 **GAD Submissions** | GAD submissions | Clear submissions |
| 📅 **GAD Agendas** | GAD agendas | Remove agendas |
| 📖 **GAD Guidelines** | GAD guidelines | Delete guidelines |
| 👤 **GAD Coordinators** | Coordinators | Remove coordinators |
| 💰 **GAD Plan & Budgets** | Plans and budgets | Clear plans |
| 🎓 **Enrollments** | Enrollment records | Reset enrollments |
| 👔 **Staff** | Staff records | Clear staff |
| 🏢 **Colleges** | College records | Remove colleges |

## ⚙️ How It Works

### Running a Seeder
1. Click **"Run Seeder"** button on any seeder card
2. Review confirmation dialog
3. Click **"Run"** to confirm
4. Wait for success message
5. Statistics automatically update

### Wiping Data
1. Click **"Wipe Data"** button on any section card
2. Review the **danger warning**
3. Click **"Delete Permanently"** to confirm (shown only on danger confirmations)
4. Wait for success message
5. Statistics automatically update

## ⚠️ Important Notes

- ✅ Each section has its **own independent button** - no bulk operations
- ✅ **Confirmation modals** prevent accidental operations
- ✅ **Real-time statistics** show current record counts
- ⚠️ **Data deletion is permanent** - cannot be undone
- 🔐 **Admin authentication required** - protected by admin middleware
- 🛡️ **CSRF protected** - all requests verified

## 🎯 Common Use Cases

### Development Setup
1. Go to Seeder Management
2. Run: "Enrollment Data" (includes staff & colleges)
3. Run: "Announcements"
4. Run: "Statistics"
5. Run: "Programs & Colleges"
6. Your dev database is now populated!

### Clean Slate
1. Click each "Wipe Data" button for sections you want to clear
2. Then re-run seeders to repopulate with fresh data
3. Perfect for testing data import/export features

### Targeted Testing
1. Wipe only the section you're working on
2. Keep other data intact for comprehensive testing
3. Re-run just that seeder to get fresh test data

## 🔗 Dashboard Navigation

The Seeder & Data Management card appears at the top of the Admin Dashboard:
- Yellow background for visibility
- Quick access link: **"Seeder & Data Mgmt"**
- Describes: "Run seeders & wipe data"

## 📱 Responsive Design

Works perfectly on:
- ✅ Desktop (full grid layout)
- ✅ Tablet (2-column layout)
- ✅ Mobile (single column)

## 🎨 User Interface Features

- 📊 Live statistics with record counts
- 🔄 Auto-refresh after actions
- ⏱️ Loading states on buttons
- ✨ Smooth animations
- 🎯 Clear descriptions
- 🔔 Success/error notifications
- 🔒 Safety confirmations

## ⚡ Tips & Tricks

- **Fast Testing**: Use Wipe + Seeder buttons together for quick resets
- **Selective**: Don't wipe everything - use individual buttons
- **Statistics**: Check stats before/after to verify operations
- **Monitoring**: Keep browser console open for advanced debugging

## 🆘 Troubleshooting

**Buttons not working?**
- Check admin authentication (are you logged in?)
- Try refreshing the page
- Check browser console for errors

**Statistics not updating?**
- Statistics load automatically every 5 seconds
- Manually refresh page if needed

**Seeder fails?**
- Check database connections
- Verify all tables exist (run migrations)
- Check Laravel logs in `storage/logs/`

**Data not deleted?**
- Refresh page to see updated counts
- Check if there are foreign key constraints
- Verify admin permissions

---

**Version**: 1.0.0  
**Last Updated**: May 11, 2026
