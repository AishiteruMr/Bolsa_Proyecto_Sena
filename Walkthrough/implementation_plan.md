# Plan: Fix Instructor Projects Visibility

The instructor's projects are not appearing because the code is querying the `ins_usr_documento` column using the `usr_id` (numeric PK) instead of the actual document number (cédula). I will add a helper to retrieve the document from the session and update the controller.

## Proposed Changes

### [Helpers]

#### [MODIFY] [helpers.php](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Helpers/helpers.php)
- Add `cdocumento()` function to return `session('documento')`.

### [Controllers]

#### [MODIFY] [InstructorController.php](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Http/Controllers/InstructorController.php)
- Replace [cuser_id()](file:///c:/laragon/www/Bolsa_Proyecto_Sena/app/Helpers/helpers.php#4-10) with `cdocumento()` in all queries targeting the `ins_usr_documento` column.

## Verification Plan

### Manual Verification
- Log in as an instructor and verify that assigned projects appear in the dashboard and "Proyectos" view.
