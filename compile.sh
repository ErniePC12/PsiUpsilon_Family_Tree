#/opt/local/bin/php54

echo "Creating Main Page";
/opt/local/bin/php54 -f dny_members.php > index.html ; 
echo "Creating Majors Page";
/opt/local/bin/php54 -f dny_majors.php > majors.html ; 
echo "Creating Minors Page";
/opt/local/bin/php54 -f dny_minors.php > minors.html ;
echo "Creating Sponsors Page";
/opt/local/bin/php54 -f dny_sponsors.php > sponsors.html ;
