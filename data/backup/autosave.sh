#!/bin/bash

# Color codes
RESET="\e[0m"
HEADER_COLOR="\e[1;35m"    # Bright Magenta (Bold)
INFO_COLOR="\e[1;32m"      # Bright Green (Bold)
SEPARATOR_COLOR="\e[1;36m" # Bright Cyan (Bold)
ERROR_COLOR="\e[1;31m"     # Bright Red (Bold)
TABLE_HEADER_COLOR="\e[1;33m" # Bright Yellow (Bold)
TABLE_CONTENT_COLOR="\e[1;34m" # Bright Blue
PROMPT_COLOR="\e[1;37m"    # Bright White

# Function to show the welcome screen
show_welcome_screen() {
    clear
    echo -e "${SEPARATOR_COLOR}================================================================="
    echo -e "                    ${INFO_COLOR}Welcome to AutoDataSave!"
    echo -e "${SEPARATOR_COLOR}================================================================="
    echo -e "${HEADER_COLOR}This script will run periodically and save your database."
    echo -e "        You can set the delay between each execution"
    echo -e "                Press Ctrl+C to stop the script."
    echo -e "${SEPARATOR_COLOR}=================================================================${RESET}"
    echo
}

# Function to display saving info
show_info() {
    echo -e "${INFO_COLOR}Saving the Database at ${SEPARATOR_COLOR}$(date)${RESET}..."
}


# Function to print the time table
print_time_table() {
    echo -e "${TABLE_HEADER_COLOR}=============================="
    echo -e " Time Duration Conversion Table"
    echo -e "=============================="
    echo -e "| Time (hh:mm:ss) | Seconds |"
    echo -e "==============================${RESET}"
    
    # Example durations and their conversion to seconds
    durations=("01:00:00" "00:30:00" "00:15:00" "00:05:00" "00:01:00")
    
    for duration in "${durations[@]}"; do
        # Convert hh:mm:ss to seconds
        IFS=':' read -r hours minutes seconds <<< "$duration"
        total_seconds=$((hours * 3600 + minutes * 60 + seconds))
        
        # Print each line in the table
        printf "| ${TABLE_CONTENT_COLOR}%-15s${RESET} | ${TABLE_CONTENT_COLOR}%-7d${RESET} |\n" "$duration" "$total_seconds"
    done
    
    echo -e "${TABLE_HEADER_COLOR}==============================${RESET}"
}

# Welcome screen
show_welcome_screen

# Table reference
echo -e "${PROMPT_COLOR}For reference :"
echo
print_time_table
echo

# Prompt user for delay
echo -n -e "${PROMPT_COLOR}Delay (in seconds): ${RESET}"
read -r delay

# Check if the input is a valid number, and display error if invalid
if ! [[ "$delay" =~ ^[0-9]+$ ]]; then
    echo -e "${ERROR_COLOR}Invalid input. Please enter a valid number.${RESET}"
    exit 1
fi

echo -e "${INFO_COLOR}The script will now save your data every $delay seconds.${RESET}"

while true; do
    show_info
    curl -s http://lakartxela.iutbayonne.univ-pau.fr/~koulai001/SAE/COVOIT-ETUD/data/backup/backup.php -o "%TEMP%\tempfile.txt" && del "%TEMP%\tempfile.txt"
    sleep $delay
done