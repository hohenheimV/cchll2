<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Storage;
use App\Model\ePALM;
use App\Model\ePALM_draf;
use App\Model\MaklumatPenggunaPbt;
use App\Model\MaklumatPenggunaPenggiatIndustri;
use App\Model\Negeri;
use Illuminate\Support\Facades\DB;


class DataController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function testUpload(Request $request) {
        $file = $request->file('supporting_documents');
        if ($file) {
            $file->storeAs('public/uploads', $file->getClientOriginalName());
            return response()->json(['message' => 'File uploaded successfully!']);
        }
        return response()->json(['message' => 'No file uploaded!'], 400);
    }
    public function uploadChunk(Request $request)
    {
        // dd($request->all());
        $chunk = $request->input('chunk');
        $totalChunks = $request->input('totalChunks');
        $fileName = $request->input('fileName');
        $destinationFolder = $request->input('destinationFolder');
        $deleteThis = $request->input('deleteThis');
    
        // Ensure the chunk directory exists
        $chunksDirectory = storage_path('app/public/chunks');
        if (!is_dir($chunksDirectory)) {
            mkdir($chunksDirectory, 0777, true);
        }
        // dd($request->all());
        // Validate the uploaded file
        // $request->validate([
        //     'large_file' => 'required|file|mimes:jpeg,jpg,png,pdf,zip|max:10240',
        // ]);
        
        // Ensure the file is uploaded
        if (!$request->hasFile('large_file')) {
            return response()->json(['error' => 'No file uploaded']);
        }

        if ($deleteThis != '' && ($deleteThis != $fileName)) {
            $filePath = storage_path('app/public/uploads/'.$destinationFolder . $deleteThis);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    
        // Store the chunk temporarily
        $chunkFile = $request->file('large_file');
        // dd($request->all());
        try {
            $chunkFile->storeAs('public/chunks', $fileName . '.' . $chunk);
        } catch (\Exception $e) {
            // \Log::error('Error uploading chunk: ' . $e->getMessage());
            return response()->json(['error' => 'Error uploading chunk: ' . $e->getMessage()]);
        }
        // dd($request->all());
        // If all chunks are uploaded, merge them into a single file
        if ($chunk + 1 == $totalChunks) {
            $this->mergeChunks($fileName, $totalChunks, $destinationFolder);
        }
        // dd($request->all());
        return response()->json(['success' => true, 'message' => 'Chunk uploaded']);
    }

    private function mergeChunks($fileName, $totalChunks, $destinationFolder)
    {
        // dd($fileName);
        // Ensure the uploads directory exists
        $uploadsDirectory = storage_path('app/public/uploads/'.$destinationFolder);
        if (!is_dir($uploadsDirectory)) {
            mkdir($uploadsDirectory, 0777, true);
        }
        // dd($fileName);
        $filePath = storage_path('app/public/uploads/'.$destinationFolder . $fileName);
    
        // Open the file in append mode
        $file = fopen($filePath, 'ab');
        // dd($fileName);
        // Append each chunk in order
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkPath = storage_path('app/public/chunks/' . $fileName . '.' . $i);
            $chunk = fopen($chunkPath, 'rb');
            stream_copy_to_stream($chunk, $file);
            fclose($chunk);
    
            // Optionally, delete the chunk after it's been merged
            unlink($chunkPath);
        }
        // dd($fileName);
        fclose($file);
        // dd($fileName);
        // Optionally, move the file to a final location or process it further
        // Storage::move($filePath, 'public/uploads/' . $fileName);
        // Storage::put('public/uploads/' . $fileName, file_get_contents($filePath));

        // dd($fileName);
    }

    // public function uploadChunk(Request $request)
    // {
    //     $chunk = $request->input('chunk');
    //     $totalChunks = $request->input('totalChunks');
    //     $fileName = $request->input('fileName');
        
    //     // Ensure the chunk directory exists
    //     $chunksDirectory = storage_path('app/public/chunks');
    //     if (!is_dir($chunksDirectory)) {
    //         mkdir($chunksDirectory, 0777, true);
    //     }

    //     // Ensure the file is uploaded
    //     if (!$request->hasFile('supporting_documents')) {
    //         return response()->json(['error' => 'No file uploaded']);
    //     }

    //     // Store the chunk temporarily
    //     $chunkFile = $request->file('supporting_documents');
    //     try {
    //         $chunkFile->storeAs('public/chunks', $fileName . '.' . $chunk);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Error uploading chunk: ' . $e->getMessage()]);
    //     }

    //     // If all chunks are uploaded, merge them into a single file
    //     if ($chunk + 1 == $totalChunks) {
    //         $this->mergeChunks($fileName, $totalChunks);
    //     }

    //     return response()->json(['success' => true, 'message' => 'Chunk uploaded']);
    // }

    // private function mergeChunks($fileName, $totalChunks)
    // {
    //     // Ensure the uploads directory exists
    //     $uploadsDirectory = storage_path('app/public/uploads');
    //     if (!is_dir($uploadsDirectory)) {
    //         mkdir($uploadsDirectory, 0777, true);
    //     }

    //     $filePath = storage_path('app/public/uploads/' . $fileName);
    //     $file = fopen($filePath, 'ab');

    //     // Append each chunk in order
    //     for ($i = 0; $i < $totalChunks; $i++) {
    //         $chunkPath = storage_path('app/public/chunks/' . $fileName . '.' . $i);
    //         if (file_exists($chunkPath)) {
    //             $chunk = fopen($chunkPath, 'rb');
    //             stream_copy_to_stream($chunk, $file);
    //             fclose($chunk);
                
    //             // Optionally, delete the chunk after it's been merged
    //             unlink($chunkPath);
    //         }
    //     }

    //     fclose($file);

    //     // Move the final file to a final location
    //     Storage::put('public/uploads/' . $fileName, file_get_contents($filePath));
    //     // Optionally delete the merged temp file after storing it in the final location
    //     unlink($filePath);
    // }
    
    // Function to fetch HTML content from a URL using file_get_contents
    private function fetchHtmlContent($url = 'https://portalosc.kpkt.gov.my/osc/PBT2_index.cfm?Neg=00&Taraf=0&S=2') {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: PHP/' . phpversion(),
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ]);

        $htmlContent = @file_get_contents($url, false, $context);

        if ($htmlContent === false) {
            $error = error_get_last();
            return response()->json(['error' => 'Error fetching data: ' . $error['message']], 500);
        }

        return $htmlContent;
    }

    // Function to clean the text by removing non-alphabetic characters
    private function cleanText($text) {
        // Remove non-alphabetic characters, keeping spaces
        return preg_replace('/[^a-zA-Z\s]/', '', $text);
    }

    // Function to extract Jumlah PBT value
    private function extractJumlahPBT($htmlContent) {
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $xpath = new \DOMXPath($dom);

        // Query for the <strong> tag containing the Jumlah PBT value
        $nodes = $xpath->query('//div[@align="center"]//p//font//strong');
        foreach ($nodes as $node) {
            $text = trim($node->nodeValue);
            // Extract numeric value
            if (preg_match('/(\d+)/', $text, $matches)) {
                return $matches[1]; // Return the matched value
            }
        }
        return 'Not found'; // Return 'Not found' if not matched
    }

    // Function to parse and organize the table data
    private function parseAndOrganizeTable($htmlContent) {
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $xpath = new \DOMXPath($dom);
        $organizedData = [];

        // Extract table rows
        $rows = $xpath->query('//table//tr');
        $previousColspanText = '';

        foreach ($rows as $index => $row) {
            // Check for colspan="4" in the current row
            $colspan4 = $xpath->query('.//td[@colspan="4"]', $row);
            if ($colspan4->length > 0) {
                $previousColspanText = strtoupper($this->cleanText(trim($colspan4[0]->textContent)));
            } else {
                // Get all the cells in the current row
                $cells = $row->getElementsByTagName('td');
                if ($cells->length > 0) {
                    $dataRow = [];
                    foreach ($cells as $cellIndex => $cell) {
                        $text = trim($cell->textContent);

                        if ($cellIndex == 0) { // 1st column
                            $dataRow[] = strtoupper($previousColspanText); // Include colspan text
                        } elseif ($cellIndex == 1) { // 2nd column (0-based index 1)
                            $dataRow[] = $previousColspanText ? strtoupper($this->cleanText($text)) : strtoupper($this->cleanText($text));
                        } elseif ($cellIndex == 2) { // 3rd column (0-based index 2)
                            $dataRow[] = strtoupper(trim($text));
                        } else {
                            $dataRow[] = strtoupper($this->cleanText($text));
                        }
                    }
                    if (!empty($dataRow) && $index >= 5) { // Exclude the first 5 rows
                        // Trim spaces in the address (alamat) column specifically
                        $dataRow[2] = strtoupper(trim($dataRow[2]));
                        $organizedData[] = $dataRow;
                    }
                }
            }
        }

        return $organizedData;
    }

    // Function to generate SQL insert statements
    private function generateSqlInsert($data) {
        $sql = "INSERT INTO PBT (id, id_negeri, nama_negeri, id_pbt, nama_pbt, alamat, abbrv) VALUES\n";
        $values = [];

        foreach ($data as $index => $row) {
            $id = $index + 1;
            $id_negeri = $id; // Assume id_negeri corresponds to id for simplicity
            $nama_negeri = isset($row[0]) ? addslashes($row[0]) : '';
            $id_pbt = $id;
            $nama_pbt = isset($row[1]) ? addslashes($row[1]) : '';
            $alamat = isset($row[2]) ? addslashes($row[2]) : '';
            $abbrv = isset($row[3]) ? addslashes($row[3]) : '';

            $values[] = "('$id', '$id_negeri', '$nama_negeri', '$id_pbt', '$nama_pbt', '$alamat', '$abbrv')";
        }

        $sql .= implode(",\n", $values) . ";";
        return $sql;
    }

    // Function to parse and organize the table data
    private function parseNegeri($htmlContent) {
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $xpath = new \DOMXPath($dom);
        $organizedData = [];

        // Extract table rows
        $rows = $xpath->query('//table//tr');
        $previousColspanText = '';

        foreach ($rows as $index => $row) {
            // Check for colspan="4" in the current row
            $colspan4 = $xpath->query('.//td[@colspan="4"]', $row);
            if ($colspan4->length > 0) {
                // $nextId = sizeof($organizedData);
                $organizedData[] = ['id' => count($organizedData), 'name' => trim(strtoupper($this->cleanText(($colspan4[0]->textContent))))];
            }
        }

        return $organizedData;
    }

    // Function to parse and organize the table data
    private function parsePBT($htmlContent) {
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);
        $xpath = new \DOMXPath($dom);
        $organizedData = [];
        $regionIndices = [];
        $currentIndex = 1;
    
        // Extract table rows
        $rows = $xpath->query('//table//tr');
        $previousColspanText = '';
    
        foreach ($rows as $index => $row) {
            // Check for colspan="4" in the current row
            $colspan4 = $xpath->query('.//td[@colspan="4"]', $row);
            if ($colspan4->length > 0) {
                $previousColspanText = strtoupper($this->cleanText(trim($colspan4[0]->textContent)));
                // Assign an index to the region if not already assigned
                if (!isset($regionIndices[$previousColspanText])) {
                    $regionIndices[$previousColspanText] = $currentIndex++;
                }
            } else {
                // Get all the cells in the current row
                $cells = $row->getElementsByTagName('td');
                if ($cells->length > 0) {
                    // Initialize an array to hold the current alamat
                    $alamat = [];

                    foreach ($cells as $cellIndex => $cell) {
                        $text = trim(preg_replace('/\s+/', ' ', $cell->textContent));

                        if ($cellIndex == 1) { // 2nd column (0-based index 1)
                            $region = strtoupper($this->cleanText($text));
                            $regionId = isset($regionIndices[$previousColspanText]) ? $regionIndices[$previousColspanText] : '';

                            if ($region != "NAMA PBT") {
                                // Initialize the region index if not already set
                                if (!isset($organizedData[$regionId])) {
                                    $organizedData[$regionId] = [];
                                }

                                // Prepare the entry in organizedData
                                $entry = [
                                    'id' => count($organizedData[$regionId]) + 1,
                                    'name' => $region,
                                    'alamat' => [] // Initialize alamat here
                                ];

                                // Add this entry to organizedData
                                $organizedData[$regionId][] = $entry;
                            }
                        }

                        // Now handle the third column (index 2) for alamat
                        if ($cellIndex == 2 && isset($organizedData[$regionId])) {
                            // Assuming that the last entry added to organizedData is the one we need to update
                            $lastIndex = count($organizedData[$regionId]) - 1;

                            // Populate alamat
                            $address = $this->processAddress(trim(strtoupper($text))); // Get the alamat from this cell
                            $organizedData[$regionId][$lastIndex]['alamat'] = [
                                'alamat1' => $address["alamat1"], // Example value from cell index 2
                                'poskod' => $address["poskod"], // Example static value, modify as needed
                                'kawasan' => $address["kawasan"], // Example static value, modify as needed
                                'negeri' => trim($previousColspanText) // Example static value, modify as needed
                            ];
                        }
                    }
                }

            }
        }
    
        return $organizedData;
    }

    // Main function to handle URL processing, data extraction, and SQL generation
    public function processData() {
        $url = 'https://portalosc.kpkt.gov.my/osc/PBT2_index.cfm?Neg=00&Taraf=0&S=2';
        
        $htmlContent = $this->fetchHtmlContent($url);
        // dd($htmlContent);
        $jumlahPBT = $this->extractJumlahPBT($htmlContent);
        $organizedData = $this->parseAndOrganizeTable($htmlContent);
        // return "YOSHA";
        // Display the organized table data
        dd($organizedData);
        return view('data', [
            'data' => $organizedData,
            'sqlQuery' => $this->generateSqlInsert($organizedData),
            'jumlahPBT' => $jumlahPBT,
        ]);
    }

    public function getNegeri($shortName = null) {
        // $url = 'https://portalosc.kpkt.gov.my/osc/PBT2_index.cfm?Neg=00&Taraf=0&S=2';
        
        // $htmlContent = $this->fetchHtmlContent($url);
        // dd($htmlContent);
        $negeri = array_slice($this->parseNegeri($this->fetchHtmlContent()), 1);
        if($shortName != null){
            // Iterate through the states array
            foreach ($negeri as $state) {
                // Check if the name contains the search string (case insensitive)
                if (stripos($state['name'], $shortName) !== false) {
                    $negeri = $state['name'];
                    break; // Stop the loop once we find the first match
                }
            }
            $kod_negeri = Negeri::select('kod_negeri')
                ->where('nama_negeri', 'ilike', "%$shortName%")
                ->first();
            if ($kod_negeri) {
                $negeri = $kod_negeri->kod_negeri;
            }
        }

        // $organizedData = $this->parseAndOrganizeTable($htmlContent);
        // return "YOSHA";
        // Display the organized table data
        // dd(array_slice($negeri, 1));
        // return view('data', [
        //     'data' => $organizedData,
        //     'sqlQuery' => $this->generateSqlInsert($organizedData),
        //     'jumlahPBT' => $jumlahPBT,
        // ]);
        return response()->json($negeri);
    }

    public function getPBT($negeriId, $pbtId = null) {
        // $url = 'https://portalosc.kpkt.gov.my/osc/PBT2_index.cfm?Neg=00&Taraf=0&S=2';
        
        // $htmlContent = $this->fetchHtmlContent($url);
        // dd($htmlContent);
        $PBT = array_slice($this->parsePBT($this->fetchHtmlContent()), 1);
        $PBT = ($this->parsePBT($this->fetchHtmlContent()));
        if($pbtId != null){
            // Iterate through the states array
            return response()->json($PBT[$negeriId][$pbtId-1]['alamat'] ?? []);
        }
        // $organizedData = $this->parseAndOrganizeTable($htmlContent);
        // return "YOSHA";
        // Display the organized table data
        // dd(array_slice($PBT, 1));
        // return view('data', [
        //     'data' => $organizedData,
        //     'sqlQuery' => $this->generateSqlInsert($organizedData),
        //     'jumlahPBT' => $jumlahPBT,
        // ]);
        return response()->json($PBT[$negeriId] ?? []);
    }

    public function getPostcode($postcode){
        // $postcode = htmlspecialchars($_GET['postcode']);

        // Define the URL for postcode lookup
        $url = "https://postcode.my/search/?keyword={$postcode}&state=";

        // Create a context with a user agent to mimic a real browser
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => 'User-Agent: PHP/' . phpversion()
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);

        // Fetch the HTML content
        $htmlContent = @file_get_contents($url, false, $context);

        if ($htmlContent === false) {
            echo json_encode([]);
            exit;
        }


        // Load the HTML content into DOMDocument
        $dom = new \DOMDocument();
        @$dom->loadHTML($htmlContent);

        // Use DOMXPath to query the HTML
        $xpath = new \DOMXPath($dom);

        // Find the table with id="t2"
        $table = $xpath->query('//table[@id="t2"]')->item(0);
        $data = [];
        if ($table) {
            // Get rows from the table
            $rows = $table->getElementsByTagName('tr');

            // Check if there are at least 2 rows
            if ($rows->length > 1) {
                $secondRow = $rows->item(1);
                $columns = $secondRow->getElementsByTagName('td');
                if ($rows->length > 2) {
                    $secondRow = $rows->item(2);
                    $columns = $secondRow->getElementsByTagName('td');
                }
                if ($columns->length > 2) {
                    // Extract data from the second and third columns
                    $locality = trim($columns->item(1)->textContent);
                    $state = trim($columns->item(2)->textContent);
                    
                    $kod_negeri = Negeri::select('kod_negeri')
                        ->where('nama_negeri', 'ilike', "%$state%")
                        ->first();
                    if ($kod_negeri) {
                        $kod_negeri = $kod_negeri->kod_negeri;
                    } else {
                        $kod_negeri = null;
                    }
                    $data = [
                        'locality' => $locality,
                        'state' => $state,
                        'kod_negeri' => $kod_negeri,
                        'country' => 'Malaysia' // Assuming country is always Malaysia for this case
                    ];

                    // echo json_encode($data);
                }
            }
        }
        return response()->json($data ?? []);
    }

    public function processAddress($string) {
        // Trim the input string
        $string = trim($string);
        
        // Use regex to find the 5-digit postal code
        if (preg_match('/(\d{5})/', $string, $matches, PREG_OFFSET_CAPTURE)) {
            $postalCode = $matches[0][0]; // Extract the postal code
            $postalCodePosition = $matches[0][1]; // Get the position of the postal code
            
            // Split the string into parts
            $alamat1 = substr($string, 0, $postalCodePosition); // Before the postal code
            $kawasan = substr($string, $postalCodePosition + 6); // After the postal code (including a space)
    
            // Clean up the results
            $alamat1 = trim($alamat1); // Trim any leading/trailing spaces
            $kawasan = trim($kawasan); // Trim any leading/trailing spaces
    
            // Prepare the processed array
            $processed = [
                'alamat1' => $alamat1,
                'poskod' => $postalCode,
                'kawasan' => $kawasan
            ];
    
            return $processed;
        }
    
        // If no postal code is found, return empty results
        return [
            'alamat1' => '',
            'poskod' => '',
            'kawasan' => ''
        ];
    }

    public function fetchComponents($id_taman)
    {
        // $this->middleware(['role_or_permission:Pentadsbir Sistem|TsKP/B JLN|Pegaswai|Piswhak Berkuasa Tempatan|esLAPS-list']);
        if(auth()->id()){
            // User::find($userId);
            // dd(auth()->id());
            // dd($id_taman);
            // Assuming you're fetching ePALM components related to a particular taman
            $ePALM = ePALM_draf::find($id_taman); // or pass the ID from the request if needed
            if ($ePALM && $ePALM->kategori_taman == "Landskap Perbandaran") {
                $folder = $ePALM->nama_taman;
                $ePALM_komponen = ePALM_draf::where('is_komponen', $ePALM->id_taman)->get();
                // $ePALM->komponen = $ePALM_komponen;
                $ePALM_komponen->each(function ($komponen) use ($folder) {
                    $komponen->folder = str_replace(' ', '_', $folder);
                });
                // If you want to send back the necessary data to display in the front-end
                $imagePaths = [];
                foreach ($ePALM_komponen as $komponen) {
                    $imagePaths[] = [
                        'nama_taman' => $komponen->nama_taman,
                        'keterangan_taman' => $komponen->keterangan_taman,
                        'is_komponen' => $komponen->is_komponen,
                        'images' => $this->getImagePaths($komponen),
                        'id_taman' => $komponen->id_taman,
                        'gambar_taman' => $komponen->gambar_taman,
                    ];
                }

                return response()->json(['success' => true, 'data' => $imagePaths]);
            }

            return response()->json(['success' => false, 'message' => 'No data found']);
        }else{
            abort(403, 'You are not authorized to access this page.');
        }
    }

    // Helper function to get image paths
    public function getImagePaths($komponen)
    {
        // dd($komponen);
        $gambar_tamanData = json_decode($komponen->gambar_taman, true);
        $folderName = str_replace(' ', '_', $komponen->folder);
        $subfolderName = str_replace(' ', '_', $komponen->nama_taman);
        // dd($folderName);
        // $gambar_input_modal_1 = isset($gambar_tamanData['gambar_input_modal_1']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_1'] : null;
        // $gambar_input_modal_2 = isset($gambar_tamanData['gambar_input_modal_2']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_2'] : null;
        // $gambar_input_modal_3 = isset($gambar_tamanData['gambar_input_modal_3']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_3'] : null;
        // $gambar_input_modal_4 = isset($gambar_tamanData['gambar_input_modal_4']) ? $folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_4'] : null;

        // return [
        //     asset('storage/uploads/ePALM/' . $gambar_input_modal_1),
        //     asset('storage/uploads/ePALM/' . $gambar_input_modal_2),
        //     asset('storage/uploads/ePALM/' . $gambar_input_modal_3),
        //     asset('storage/uploads/ePALM/' . $gambar_input_modal_4)
        // ];
        $gambar_input_modal_1 = isset($gambar_tamanData['gambar_input_modal_1']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_1'] : 'no-photos.png';
        $gambar_input_modal_2 = isset($gambar_tamanData['gambar_input_modal_2']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_2'] : 'no-photos.png';
        $gambar_input_modal_3 = isset($gambar_tamanData['gambar_input_modal_3']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_3'] : 'no-photos.png';
        $gambar_input_modal_4 = isset($gambar_tamanData['gambar_input_modal_4']) ? 'ePALM/'.$folderName.'/'.$subfolderName.'/'.$gambar_tamanData['gambar_input_modal_4'] : 'no-photos.png';

        // Add to the array of image paths
        return [
            asset('storage/uploads/' . $gambar_input_modal_1),
            asset('storage/uploads/' . $gambar_input_modal_2),
            asset('storage/uploads/' . $gambar_input_modal_3),
            asset('storage/uploads/' . $gambar_input_modal_4)
        ];
    }

    public function getPBTStatistics()
    {
        // Fetch count of PBTs grouped by state using LIKE for flexible matching
        $states = [
            'Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan',
            'Pahang', 'Penang', 'Perak', 'Perlis', 'Selangor',
            'Sabah', 'Sarawak', 'Wilayah Persekutuan'
        ];

        $pbtCounts = [];

        foreach ($states as $state) {
            $count = MaklumatPenggunaPbt::where('state', 'LIKE', '%' . $state . '%')->count();
            $pbtCounts[] = $count;
        }

        return response()->json($pbtCounts);
    }

    public function getVisitorStatistics()
    {
        $currentYear = now()->year - 1;
        // Fetch visitor counts by month from the web_visitor table
        $visitorCounts = DB::table('web_visitor')
            ->select(DB::raw("TO_CHAR(viewed_at, 'YYYY-MM') as month"), DB::raw('count(*) as count'))
            ->whereYear('viewed_at', $currentYear)
            ->groupBy(DB::raw("TO_CHAR(viewed_at, 'YYYY-MM')"))
            ->orderBy(DB::raw("TO_CHAR(viewed_at, 'YYYY-MM')"))
            ->get();

        // Return the data as JSON
        return response()->json($visitorCounts);
    }

    public function getPenggiatIndustri()
    {
        $penggiat = MaklumatPenggunaPenggiatIndustri::select('id_elind', 'name')->orderBy('id_elind', 'asc')->get();
        return response()->json($penggiat);
    }

    public function getPbtName()
    {
        $penggiat = MaklumatPenggunaPbt::select('id', 'pbt_name')->orderBy('state', 'asc')->get();
        return response()->json($penggiat);
    }
}
