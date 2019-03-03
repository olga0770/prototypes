#!/usr/bin/env bash


targetdir=/opt/lampp/htdocs//interform-templates

sourcedir=~/git/prototypes/interform-templates


rm ${targetdir}/*

cp ${sourcedir}/*.php ${sourcedir}/*.png ${sourcedir}/*.js ${sourcedir}/*.css ${sourcedir}/*.html ${targetdir}