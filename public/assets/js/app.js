// Submenu toggle
document.addEventListener('DOMContentLoaded', function () {
    // Select all elements with the class 'toggle-submenu'
    let toggles = document.querySelectorAll('.toggle-submenu');

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();  // Prevent the default action (like a page reload)

            // Get the closest parent 'li' element with the 'has-sub' class
            let parentItem = toggle.closest('.has-sub');

            // Get the submenu element
            let submenu = parentItem.querySelector('.submenu');

            // Toggle submenu-open and submenu-close classes
            if (submenu.classList.contains('submenu-close')) {
                submenu.classList.remove('submenu-close');
                submenu.classList.add('submenu-open');
            } else {
                submenu.classList.remove('submenu-open');
                submenu.classList.add('submenu-close');
            }
        });
    });
});

// delete resource
function deleteResource(url) {
    Swal.fire({
        title: "Are you sure?",
        text: "This resource will be deleted permanently.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, keep it",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "delete",
                url: url,
                data: {
                    _token: $("meta[name='csrf-token']").attr("content"),
                },
                success: function (response) {
                    Swal.fire({
                        title: "Yahoo!",
                        text: "The resource deleted successfully.",
                        icon: "success",
                    }).then((result) => {
                        window.location.href = window.location.href;
                    });
                },
                error: function (error) {
                    console.log("error:", error);
                    Swal.fire({
                        title: "Oops!",
                        text: "Something is wrong, try again.",
                        icon: "error",
                    });
                },
            });
        }
    });
}

// photo preview
function photoPreview(event, id) {
    var input = event.target;
    if (input.files && input.files[0]) {
        var image = document.getElementById(id);
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            image.src = e.target.result;
        };

        reader.readAsDataURL(file);
    }
}

function sidebarToggle() {
    const sidebar = document.querySelector('.sidebar-wrapper'); // Sidebar element
    const toggleButtons = document.querySelectorAll('.sidebar-toggler'); // Toggle buttons
    const overlay = document.querySelector('.overlay'); // Overlay element

    // Initialize sidebar state based on window size
    const setSidebarState = () => {
        if (window.innerWidth >= 992) {
            sidebar.style.left = '0'; // Open sidebar for large screens
            overlay.style.display = 'none'; // No overlay for large screens
            document.body.style.overflow = ''; // Enable scrolling
        } else {
            sidebar.style.left = '-300px'; // Hide sidebar for small screens
            overlay.style.display = 'none'; // Overlay remains hidden initially
        }
    };

    // Function to disable scrolling
    const disableScroll = () => document.body.style.overflow = 'hidden';

    // Function to enable scrolling
    const enableScroll = () => document.body.style.overflow = '';

    // Function to open the sidebar
    const openSidebar = () => {
        sidebar.style.left = '0';
        overlay.style.display = 'block'; // Show the overlay
        disableScroll();
    };

    // Function to close the sidebar
    const closeSidebar = () => {
        sidebar.style.left = '-300px';
        overlay.style.display = 'none'; // Hide the overlay
        enableScroll();
    };

    // Attach click event to each toggle button
    toggleButtons.forEach(button => {
        button.addEventListener('click', () => {
            if (window.innerWidth < 992) { // Only toggle for small screens
                if (sidebar.style.left === '0px') {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            }
        });
    });

    // Close sidebar when overlay is clicked
    overlay.addEventListener('click', () => {
        if (window.innerWidth < 992) { // Only close for small screens
            closeSidebar();
        }
    });

    // Adjust sidebar state on window resize
    window.addEventListener('resize', setSidebarState);

    // Initial setup
    setSidebarState();
}

// Initialize the sidebar toggle functionality
sidebarToggle();

// Initialize tooltips
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

document.addEventListener("DOMContentLoaded", function () {
    const calculatorModal = document.getElementById("calculator-modal");
    const showCalculator = document.getElementById("show-calculator");
    const closeCalculator = document.getElementById("close-calculator");
    const display = document.getElementById("calculator-display");
    const buttons = document.querySelectorAll(".calc-btn");

    let currentInput = "";
    let lastOperator = "";
    let result = 0;

    // Show/hide calculator
    showCalculator.addEventListener("click", (e) => {
        e.preventDefault();
        calculatorModal.classList.toggle("hidden");
    });

    closeCalculator.addEventListener("click", () => {
        calculatorModal.classList.add("hidden");
    });

    // Calculator button logic
    buttons.forEach((button) => {
        button.addEventListener("click", () => {
            const value = button.getAttribute("data-value");

            if (value === "=") {
                try {
                    currentInput = eval(currentInput);
                } catch (error) {
                    currentInput = "Error";
                }
            } else if (value === "C") {
                currentInput = "";
            } else {
                currentInput += value;
            }

            display.value = currentInput;
        });
    });
});