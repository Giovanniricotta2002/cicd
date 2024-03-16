# Vérifier si l'image Docker a été téléchargée avec succès
if docker inspect giovanni2002ynov/cicd:no-use &> /dev/null; then
    echo "L'image Docker giovanni2002ynov/cicd:no-use a été téléchargée avec succès."
    exit 0  # Succès
else
    echo "Erreur: L'image Docker giovanni2002ynov/cicd:no-use n'a pas été trouvée dans le cache local."
    exit 1  # Erreur
fi