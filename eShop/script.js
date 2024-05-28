console.log("sdmdjhd");

function setSearchPadding(open) {
    const contentItems = document.getElementById("content-items");
    if (contentItems) {
        contentItems.style.transition = "padding-top 0.5s"; // Add transition
        contentItems.style.paddingTop = open ? "60px" : "0"; // Set padding based on search box state
    }
}

function SearchOpenClose() {
    const searchbar = document.querySelector(".searchbox");
    if (searchbar.style.display === "flex") {
        searchbar.style.display = "none"; // Close the search box if it's open
        setSearchPadding(false); // Set padding to 0
    } else {
        searchbar.style.display = "flex"; // Open the search box if it's closed
        searchbar.style.zIndex = "100";
        setSearchPadding(true); // Set padding to 50px
    }
}

// Search functionality
function filterItems() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const items = document.querySelectorAll('.div1');
    let found = false;

    items.forEach(item => {
        const itemName = item.querySelector('h1').textContent.toLowerCase();
        if (itemName.includes(searchInput)) {
            item.style.display = 'block'; // Show the item if its name matches the search input
            found = true;
        } else {
            item.style.display = 'none'; // Hide the item if its name doesn't match the search input
        }
    });

    const noProductMessage = document.getElementById('noProductMessage');
    if (noProductMessage) {
        if (!found) {
            noProductMessage.style.display = 'block'; // Show "No product found" message
        } else {
            noProductMessage.style.display = 'none'; // Hide "No product found" message
        }
    }
}

// Add event listener to run filterItems on search
document.getElementById('searchInput').addEventListener('input', filterItems);

document.addEventListener('DOMContentLoaded', () => {
    const contentItems = document.getElementById('content-items');
    const noProductMessage = document.createElement('div');
    noProductMessage.id = 'noProductMessage';
    noProductMessage.textContent = 'No product found';
    noProductMessage.style.display = 'none'; // Hide initially
    contentItems.appendChild(noProductMessage);
});


