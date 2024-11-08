function loadCommunes() {
    const wilayaNom = document.getElementById("wilaya").value;

    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../fetch_communes.php?wilayaNom=" + wilayaNom, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const communes = JSON.parse(xhr.responseText);
                    const communeDropdown = document.getElementById("commune");

                    // Clear existing options
                    communeDropdown.innerHTML = "";

                    if (communes.length > 0) {
                        // Populate commune dropdown if communes exist
                        communes.forEach(commune => {
                            const option = document.createElement("option");
                            option.value = commune.nom_commune;
                            option.text = commune.nom_commune;
                            communeDropdown.appendChild(option);
                        });
                    } else {
                        // If no communes found, add default option
                        const defaultOption = document.createElement("option");
                        defaultOption.text = "No communes available";
                        communeDropdown.appendChild(defaultOption);
                    }
                } catch (e) {
                    console.error("Failed to parse JSON:", e);
                }
            } else {
                console.error("AJAX Error:", xhr.statusText);
            }
        }
    };
    xhr.send();
}
