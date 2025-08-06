<?php

namespace App\Services;

use App\Console\Commands\ImportCsvCommand;
use Illuminate\Console\OutputStyle;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class ImportCsvService
{
    public function importFromUploadedFile(UploadedFile $file): array
    {
        $validation = $this->validateFile($file);
        if (! $validation['valid']) {
            return [
                'success' => false,
                'output' => $validation['message'],
                'result_code' => 1,
            ];
        }

        $fileName = 'csv_import_'.time().'_'.$file->getClientOriginalName();

        $filePath = $file->storeAs('temp', $fileName);
        $fullPath = Storage::path($filePath);

        try {
            $command = new ImportCsvCommand;
            $command->setLaravel(app());

            $input = new ArrayInput(['file' => $fullPath]);
            $input->bind($command->getDefinition());

            $output = new BufferedOutput;
            $outputStyle = new OutputStyle($input, $output);

            $command->setInput($input);
            $command->setOutput($outputStyle);

            $result = $command->handle();
            $outputContent = $output->fetch();

            return [
                'success' => $result === 0,
                'output' => $outputContent,
                'result_code' => $result,
            ];

        } finally {
            Storage::delete($filePath);
        }
    }

    private function validateFile(UploadedFile $file): array
    {
        $validator = Validator::make(['file' => $file], [
            'file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        if ($validator->fails()) {
            return [
                'valid' => false,
                'message' => 'File validation failed: '.$validator->errors()->first(),
            ];
        }

        return [
            'valid' => true,
            'message' => '',
        ];
    }
}
