import { requestGetPermissionByRole } from "../helpers/requestGetPermissionByRole";
import { templatePermissions, templateUnassignedPermission } from "../template/permissions";

const role = document.querySelector('#role');
const group = document.querySelector('#group');
const contentListPermission = document.querySelector('#listPermission');
const unassignedPermissions = document.querySelector('#unassigned-permissions');

const alertAddPermission = document.querySelector('#alert-add-permission');
const alertRemovePermission = document.querySelector('#alert-remove-permission')


let permissionsLocalStorage = [];
let timeOutHide = 4000;



export const managePermissionsOfRole = () => {

    const hiddeAlert = ()=>{
        setTimeout(()=>{
            alertAddPermission.classList.add('hidden');
            alertRemovePermission.classList.add('hidden');    
        },timeOutHide)
    }


    // Handle function for the permissions data
    const handleSuccessPermissions = (data) => {
        const { permissions } = data;

        contentListPermission.innerHTML = templatePermissions(permissions);

        alertAddPermission.classList.remove('hidden');
        alertRemovePermission.classList.add('hidden');

        // Hidde alert
        hiddeAlert();

    }

    // Handle function for the errors of get permissions data
    const handleErrorPermissions = (error) => {
        console.log(error);
    }

    // Handle function for role change
    const handleRoleChange = () => {

        if (group.value < 3) {
            role.selectedIndex = 2;
        } else {
            role.selectedIndex = 1;
        }

        let groupValue = group.value;
        let roleValue = role.value;

        // If group is superadmin, selected rol superadmin


        if (roleValue == "" || roleValue == null) return;

        // Validate if the rol is admin and group is null, the user must select group
        if (roleValue >= 2 && (groupValue == "" || groupValue == null)) {
            console.log('Debe seleccionar un grupo')
            return;
        }

        let key = `${groupValue}-${roleValue}`;

        if (permissionsLocalStorage[key]) {
            handleSuccessPermissions({ permissions: permissionsLocalStorage[key] });
        } else {

            // Request for get permission by role
            requestGetPermissionByRole(roleValue, groupValue)
                .then((data) => {
                    permissionsLocalStorage[key] = data.permissions;
                    handleSuccessPermissions(data);
                })
                .catch(handleErrorPermissions)
        }

    }






    // Handle function for remove permissions
    const handleContentListPermissions = ({ target }) => {
        if (target.closest('.deletePermissions')) {
            const btnDelete = target.closest('.deletePermissions');
            const itemPermission = btnDelete.closest('li');

            const dataSelect = {
                'id': itemPermission.id,
                'name': itemPermission.dataset.name
            }

            unassignedPermissions.insertAdjacentHTML('beforeend', templateUnassignedPermission(dataSelect));

            itemPermission.remove();

            alertAddPermission.classList.add('hidden');
            alertRemovePermission.classList.remove('hidden');

            hiddeAlert();
        }
    }

    // Handle function for add permissions
    const handleAddPermission = ({ target }) => {

        let optionSelected = target.options[target.selectedIndex];

        const data = [{
            id: target.value,
            name: optionSelected.text
        }];

        contentListPermission.insertAdjacentHTML('beforeend', templatePermissions(data));

        optionSelected.remove();

        if (target.options.length > 0) {
            target.selectedIndex = 0;
        }

        alertAddPermission.classList.remove('hidden');
        alertRemovePermission.classList.add('hidden');

        hiddeAlert();

    }

    // Event for permissions select unassigned
    unassignedPermissions.addEventListener('change', handleAddPermission)

    // Event form role select
    role.addEventListener('change', handleRoleChange);
    group.addEventListener('change', handleRoleChange)

    // Container list permissions
    contentListPermission.addEventListener('click', handleContentListPermissions)


}