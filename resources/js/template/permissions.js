// Template htm for permissions
const templatePermissions = (data) => {

    return data.map(permission => {

        return `<li id="${permission.id}" data-name="${permission.name}" class="flex justify-between items-center p-2 bg-gray-100 bg-gray-700 rounded mb-2">
                    ${permission.name}
                    <span class="text-red-500 cursor-pointer deletePermissions">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30px" height="30px" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </li>`
    }).join('');
}

const templateUnassignedPermission = (item)=>{
    return `<option value="${item.id}">${item.name}</option>`;
}

export {templatePermissions, templateUnassignedPermission}