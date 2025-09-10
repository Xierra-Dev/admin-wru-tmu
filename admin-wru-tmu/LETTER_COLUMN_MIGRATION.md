# Letter Column Addition to M-Loc Tables

## Overview
This migration adds a boolean `letter` column to the `m_loc` and `tmp_mloc` tables to track whether a letter is required for location requests.

## Database Changes

### 1. Main Table: `m_loc`
- **Column Name**: `letter`
- **Data Type**: `tinyint(1)` (MySQL boolean equivalent)
- **Default Value**: `0` (false/no)
- **Position**: After `returnDate` column
- **Comment**: "Letter flag: 0 = No, 1 = Yes (Boolean field)"

### 2. Temporary Table: `tmp_mloc`
- **Column Name**: `letter`
- **Data Type**: `tinyint(1)` (MySQL boolean equivalent)
- **Default Value**: `0` (false/no)
- **Position**: After `returnDate` column
- **Comment**: "Letter flag: 0 = No, 1 = Yes (Boolean field)"

## Files Modified

### 1. Database Schema File
- **File**: `wru_db.sql`
- **Changes**:
  - Updated `CREATE TABLE m_loc` to include letter column
  - Updated `CREATE TABLE tmp_mloc` to include letter column
  - Updated all `INSERT INTO m_loc` statements to include letter values
  - Added alternating 0 and 1 values for demonstration purposes

### 2. SQL Migration Script
- **File**: `sql_migrations/add_letter_column_to_mloc.sql`
- **Purpose**: Standalone SQL script that can be run to add the letter column
- **Features**:
  - Uses `ADD COLUMN IF NOT EXISTS` to prevent errors if column already exists
  - Includes sample data updates for demonstration
  - Compatible with existing databases

## Application Integration

The letter column is already integrated into the CodeIgniter application:

1. **Model**: `MlocModel` includes `letter` in `allowedFields`
2. **Controller**: `Mloc` controller processes letter field in store/update methods
3. **View**: Both add and edit modals include letter checkbox functionality
4. **JavaScript**: Properly handles letter checkbox state in edit modal

## Data Values

The letter field uses integer values to represent boolean states:
- `0` = No letter required
- `1` = Letter required

## Running the Migration

### Option 1: Using CodeIgniter Migration (Already Done)
The letter column has already been added via the existing migration:
```bash
php spark migrate
```

### Option 2: Using Standalone SQL Script
If you need to run the migration manually:
```sql
-- Run the contents of sql_migrations/add_letter_column_to_mloc.sql
```

### Option 3: Direct Database Import
The updated `wru_db.sql` file can be imported to a fresh database and will include the letter column structure and sample data.

## Verification

To verify the letter column exists and is working:

1. Check table structure:
   ```sql
   DESCRIBE m_loc;
   DESCRIBE tmp_mloc;
   ```

2. Test application functionality:
   - Navigate to M-Loc page
   - Try adding new entries with letter checkbox
   - Edit existing entries and verify letter checkbox reflects database value

## Notes

- The column uses `tinyint(1)` which is MySQL's standard boolean representation
- Default value of `0` ensures backward compatibility
- All existing records will have letter = 0 by default
- The migration is designed to be safe to run multiple times (idempotent)