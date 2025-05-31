<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .day {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            cursor: pointer;
        }

        .day:hover {
            background-color: #f0f0f0;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const daysContainer = document.querySelector(".calendar");

            function createCalendar() {
                const startDate = new Date();
                startDate.setDate(1); // Set the date to the first day of the month

                while (startDate.getDay() !== 0) {
                    startDate.setDate(startDate.getDate() - 1);
                }

                for (let i = 0; i < 42; i++) {
                    const dayElement = document.createElement("div");
                    dayElement.classList.add("day");
                    dayElement.textContent = startDate.getDate();
                    dayElement.addEventListener("click", () => handleDayClick(startDate.getDate()));
                    daysContainer.appendChild(dayElement);

                    startDate.setDate(startDate.getDate() + 1);
                }
            }

            function handleDayClick(day) {
                alert(`You clicked on day ${day}`);
                // Add your logic for handling the click event here
            }

            createCalendar();
        });
    </script>
</head>

<body>
    <div class="calendar"></div>
</body>

</html>