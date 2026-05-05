# Staff Import - Excel File Format Template

## 📊 Quick Reference

### File Requirements
- **Format**: .xlsx or .csv
- **Max Size**: 5 MB
- **Character Encoding**: UTF-8 (CSV)

### Column Headers (Row 1)
| Column 1 | Column 2 | Column 3 | Column 4 |
|----------|----------|----------|----------|
| No. | Name | Position | Gender |

---

## 📋 Data Entry Rules

### Office Rows
- **Column 1 (No.)**: Leave **EMPTY**
- **Column 2 (Name)**: Enter office/department name
- **Column 3 (Position)**: Leave empty
- **Column 4 (Gender)**: Leave empty

**Example:**
```
No.  | Name                    | Position | Gender
-----|-------------------------|----------|-------
     | College of Engineering  |          |
```

### Staff Rows
- **Column 1 (No.)**: Enter sequential number (1, 2, 3, etc.)
- **Column 2 (Name)**: Enter staff member name
- **Column 3 (Position)**: Enter job position/title
- **Column 4 (Gender)**: Enter M, F, or Male, Female

**Example:**
```
No. | Name          | Position          | Gender
----|---------------|-------------------|-------
1   | John Doe      | Instructor        | M
2   | Jane Smith    | Assistant Dean    | F
3   | Bob Johnson   | Administrative    | Male
```

---

## 🏢 Complete Example

```
No.  | Name                      | Position                    | Gender
-----|---------------------------|-----------------------------|---------
     | COLLEGE OF ENGINEERING    |                             |
1    | Dr. Maria Garcia          | Dean                        | Female
2    | Prof. Juan Santos         | Vice Dean                   | Male
3    | Ms. Rosa Lopez            | Administrative Officer      | Female
4    | Mr. Carlos Rodriguez      | Facilities Coordinator      | Male
     | COLLEGE OF LIBERAL ARTS   |                             |
5    | Dr. John Smith            | Dean                        | Male
6    | Prof. Sarah Davis         | Department Chair            | Female
7    | Mr. James Wilson          | Faculty                     | Male
8    | Ms. Maria Chen            | Staff Assistant             | F
     | ADMINISTRATIVE OFFICE     |                             |
9    | Mrs. Patricia Martinez    | Registrar                   | Female
10   | Mr. Robert Brown          | Accounting Manager          | M
11   | Ms. Linda Thompson        | HR Coordinator              | F
```

---

## ✅ Gender Format Options (All Valid)

| Input | Output |
|-------|--------|
| M | Male |
| m | Male |
| Male | Male |
| male | Male |
| MALE | Male |
| F | Female |
| f | Female |
| Female | Female |
| female | Female |
| FEMALE | Female |
| Other | Other |
| (anything else) | Other |

---

## ⚠️ Important Notes

1. **Office Order Matters**
   - Staff are assigned to the most recently defined office
   - Always define an office before listing its staff

2. **Don't Leave Gaps**
   - If No. column changes from empty to numeric, new office is expected
   - Ensure consistent data throughout

3. **Before Import Options**
   - ✓ **Check "Clear existing data"** to replace all data
   - ✓ **Uncheck** to append to existing records

4. **Common Mistakes**
   - Putting office names in staff rows
   - Numeric values in No. before office is defined (these rows will be skipped)
   - Inconsistent gender formatting (will be normalized automatically)

---

## 🔍 Validation Rules

The import process will:
- ✓ Skip rows with empty office (before first office defined)
- ✓ Skip rows with empty names
- ✓ Normalize gender automatically
- ✓ Ignore extra whitespace
- ✓ Count imported records in summary

---

## 📥 Example Files to Use

### CSV Format
```csv
No.,Name,Position,Gender
,"College of Engineering",,
1,Dr. Maria Garcia,Dean,Female
2,Prof. Juan Santos,Vice Dean,Male
,"College of Liberal Arts",,
3,Dr. John Smith,Dean,Male
```

### XLSX Format
Create in Excel/Sheets with same structure as CSV above.

---

## 🚀 Quick Steps

1. Create new Excel/CSV file
2. Add headers: No. | Name | Position | Gender
3. Add office rows (No. empty)
4. Add staff rows under each office (No. numeric)
5. Go to `/admin/staff/import`
6. Upload file
7. Check "Clear existing data" if replacing all
8. Click "Import File"
9. View summary and results
10. Check `/accomplishment-report` to see data displayed

---

## 📊 Expected Output

After successful import, you'll see:

**On Admin Page (/admin/staff/import)**
- Summary cards: Male count | Female count | Other count
- Breakdown table: Office | Male | Female | Other | Total

**On Accomplishment Report Page (/accomplishment-report)**
- Staff summary section with percentages
- Staff breakdown table by office

---

## ❓ Troubleshooting

| Issue | Solution |
|-------|----------|
| File rejected | Check format (.xlsx or .csv) and size (<5MB) |
| No records imported | Ensure office defined before staff rows |
| Wrong gender data | Check gender column (auto-normalized) |
| Duplicates on second import | Check "Clear existing data" first |
| 0 records | Verify No. column is numeric for staff |

---

## 📞 Support

If import fails:
1. Check file format and headers
2. Ensure office rows come before staff rows
3. Verify No. column is empty for offices, numeric for staff
4. Try sample data first to test

