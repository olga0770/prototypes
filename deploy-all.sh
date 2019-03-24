#!/usr/bin/env bash
#
# Deploy all sub projects.
#


targetdir=/opt/lampp/htdocs   #  XAMPP

sourcedir=~/git/prototypes


for dir in *; do
    if [[ -d "${dir}" ]]; then
        filename=${sourcedir}/${dir}/deploy.sh
        if [[ -f "${filename}" ]]; then
            echo  "executing script:  ${filename}", please stand by
            ${filename}
        fi
    fi
done




