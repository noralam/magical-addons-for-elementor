<?php
// Path to the Line Awesome CSS file (update with your actual file path)
$cssFilePath = MAGICAL_ADDON_PATH . 'assets/css/line-awesome.min.css';
// Path to save the JSON file (as a local path)
$jsonFilePath = MAGICAL_ADDON_PATH . 'assets/js/line-awesome.json';

// Ensure the CSS file exists
if (!file_exists($cssFilePath)) {
    echo "Error: The CSS file was not found at the specified path.";
    exit;
}

// Read the CSS file
$cssContent = file_get_contents($cssFilePath);

// Regular expression to match icon classes and Unicode values in the CSS
preg_match_all('/\.la-([a-z0-9-]+):before\s*{\s*content:\s*"\\([0-9a-fA-F]+)";\s*}/', $cssContent, $matches);

// Prepare an array with icon names and their Unicode values
$icons = [];
if (isset($matches[1]) && isset($matches[2])) {
    foreach ($matches[1] as $index => $iconName) {
        $unicode = $matches[2][$index];
        $icons[] = [
            'name' => "la-$iconName",
            'unicode' => "\\u{$unicode}"
        ];
    }
}

// Write the icons array to a JSON file
if (file_put_contents($jsonFilePath, json_encode($icons, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo "line-awesome.json file generated successfully!";
} else {
    echo "Error: Could not write to the JSON file.";
}
