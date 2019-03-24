#!/usr/bin/env bash
#
# Deploy code to web site.
#

project_name=hotel-scanner

targetdir=/opt/lampp/htdocs

sourcedir=~/git/prototypes/${project_name}

#echo; echo "sleeping..."; echo; sleep "1"

target=${targetdir}/${project_name}

echo removing "${target}"

rm -fr "${target}"

echo copying from "${sourcedir}" to "${targetdir}/"

cp -r "${sourcedir}"  "${targetdir}/"

