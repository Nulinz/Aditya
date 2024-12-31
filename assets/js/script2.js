const currentUrl = window.location.href;

const lastPart = new URL(currentUrl).pathname.split('/').pop();
// console.log(lastPart);
const classMap = {
    'dashboard.php': 'bn1',
    'dashboard2.php': 'bn1',
    'dashboard3.php': 'bn1',
    'dashboard4.php': 'bn1',
    'project_list.php': 'bn2',
    'add_project.php': 'bn2',
    'edit_project.php': 'bn2',
    'project_profile.php': 'bn2',
    'project_profile_emp.php': 'bn2',
    'employee_list.php': 'bn3',
    'add_employee.php': 'bn3',
    'edit_employee.php': 'bn3',
    'list_designation.php': 'bn4',
    'project_profile_ven_master.php': 'bn5',
    'edit_project_profile_ven_master.php': 'bn5',
    'project_profile_mat_master.php': 'bn6',
    'edit_project_profile_mat_master.php': 'bn6',
    'project_profile_headmaster.php': 'bn7',
    'edit_project_profile_headmaster.php': 'bn7',
    'project_profile_asset.php': 'bn8',
    'edit_project_profile_asset.php': 'bn8',
    'project_profile_subdivcode.php': 'bn9',
    'edit_project_profile_subdivcode.php': 'bn9',
    'list_contractor.php': 'bn10',
    'edit_contractor.php': 'bn10',
    'list_unit.php': 'bn11',
};

if (classMap[lastPart]) {
    $(`.${classMap[lastPart]}`).addClass("active");
}
