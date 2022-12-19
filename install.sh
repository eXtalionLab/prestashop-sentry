#!/usr/bin/env bash

module_name="${1}"
vendor="${2}"
vendor_short="${3:-Ext}"

if [[ "${module_name}" == "" ]]; then
    echo "Run: ${0} \$module_name [\$vendor [\$vendor_short]]"
    echo ""
    echo "Where:"
    echo " - \$module_name is in format \"Module Name\""
    echo " - \$vendor is in format \"VendorName\""
    echo " - \$vendor_short is in format \"Ven\""
    echo ""
    echo "It will give:"
    echo " - module file         - venmodulename.php"
    echo " - module class        - VenModuleName"
    echo " - display name        - Module Name"
    echo " - namespace           - VendorName\\ModuleName\\"
    echo " - routes              - vendorname_extmodulename_*"
    echo " - paths               - venmodulename/*"
    echo " - services            - venmodulename.modulename.*"
    echo " - translation domains - Modules.Venmodulename.Admin|Shop"
    echo " - entities            - Venmodulename*"
    echo " - db tables           - _DB_PREFIX_venmodulename_*"

    exit 0
fi

sedname() {
    from="${1}"
    to="${2}"
    special="${3:-}"

    echo "Sed \"${special}${from}\" to \"${special}${to}\""

    grep -srl -e "${special}${from}" \
            config/ \
            controllers/ \
            sql/ \
            src/ \
            upgrade/ \
            views/ \
            .gitignore \
            Makefile \
            composer.json \
            extmodulename.php \
            phpcs.xml.dist \
            README.md \
        | xargs sed -i "s/\(${special}\)${from}/\1${to}/g"
}

if [[ "${vendor_short}" != "Ext" ]]; then
    sedname "Extmodulename" "${vendor_short}modulename"
    sedname "ExtModuleName" "${vendor_short}ModuleName"

    vendor_short="${vendor_short,,}"
    sedname "extmodulename" "${vendor_short}modulename"
fi

if [[ "${vendor}" != "" ]]; then
    sedname "Extalion" "${vendor}"

    vendor="${vendor,,}"
    sedname "extalion" "${vendor}"
fi

sedname "Module name" "${module_name}"

module_name="${module_name// /}"
sedname "ModuleName" "${module_name}"

module_name="${module_name,,}"
sedname "modulename" "${module_name}"

vendor_short="${vendor_short,,}"

echo "Move extmodulename.php to ${vendor_short}${module_name}.php"
mv extmodulename.php "${vendor_short}${module_name}.php"

vendor_short=${vendor_short^}

echo "Move src/Controller/Admin/ModuleNameController.php to src/Controller/Admin/${vendor_short}${module_name}Controller.php"
mv src/Controller/Admin/ModuleNameController.php "src/Controller/Admin/${vendor_short}${module_name}Controller.php"

echo "Move src/Entity/ExtmodulenameConfiguration.php to src/Entity/${vendor_short}${module_name}Configuration.php"
mv src/Entity/ExtmodulenameConfiguration.php "src/Entity/${vendor_short}${module_name}Configuration.php"
