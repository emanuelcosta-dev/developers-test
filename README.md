# Neuffer developers-test

This is my solution to the Neuffers developers-test, implemented using PHP 8.4 with modern coding practices.

## Requirements

- PHP 8.4 or higher
- No external dependencies required

## Installation

1. Clone or download the repository
2. No additional installation required - uses built-in autoloader

## Usage

Run the application from the command line:

```bash
php console.php --action {action} --file {file}
```

### Parameters

- `--action` or `-a`: The mathematical operation to perform

  - `plus`: Addition of two numbers
  - `minus`: Subtraction (first - second)
  - `multiply`: Multiplication of two numbers
  - `division`: Division (first / second)

- `--file` or `-f`: Path to the CSV file containing number pairs

### Input Format

The CSV file should contain two numbers per line, separated by semicolons:

```
10;20
-30;15
45;-5
```

Numbers must be integers between -100 and 100.

### Output

The application generates two files:

1. **result.csv**: Contains results with positive values only

   - Format: `first_number;second_number;result`
   - Only results greater than 0 are included

2. **log.txt**: Contains operation logs and invalid results
   - Timestamped entries with operation start/finish
   - Invalid results (≤ 0) are logged with reasons
   - Division by zero errors are properly handled

## Testing

Test the application with the provided `test.csv` file:

```bash
# Test all operations
php console.php --action plus --file test.csv
php console.php --action minus --file test.csv
php console.php --action multiply --file test.csv
php console.php --action division --file test.csv

# Test error handling
php console.php --action invalid --file test.csv
php console.php --action plus --file nonexistent.csv
php console.php  # Missing parameters
```
