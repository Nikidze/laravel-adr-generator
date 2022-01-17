<?php

namespace Nikidze\ADRGenerator\Console\Commands;

use Illuminate\Console\Command;
use Nikidze\RepositoryGenerator\Exceptions\FileException;
use Nikidze\RepositoryGenerator\Exceptions\StubException;

class Generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:adr {title}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating adr';


    protected string $title = "";
    protected string $path = "";
    protected string $responseNamespace = "";
    protected string $requestNamespace = "";

    /**
     * Execute the console command.
     *
     * @return void
     * @throws FileException
     * @throws StubException
     */
    public function handle()
    {
        $this->title = basename($this->argument('title'));
        $this->path = dirname($this->argument('title'));
        $this->path = $this->path == '.' ? '' : $this->path;
        $this->createResponse();
        $this->createRequest();
        $this->createAction();
    }

    /**
     * Get stub content.
     *
     * @param $file
     * @return bool|string
     * @throws StubException
     */
    private function getStub($file)
    {
        $stub = __DIR__ . '/../Stubs/' . $file . '.stub';
        if (file_exists($stub)) {
            return file_get_contents($stub);
        }
        throw StubException::fileNotFound($file);
    }

    /**
     * Generate/override a file.
     *
     * @param $file
     * @param $content
     */
    private function writeFile($file, $content)
    {
        if (!file_exists($file)) {
            file_put_contents($file, $content);
        }
    }

    /**
     * @param string $folder
     * @return void
     */
    private function createFolder(string $folder): void
    {
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }
    }

    protected function createAction()
    {
        $folderToStore = "Actions/".$this->path;
        $this->createFolder(app_path() . "/Http" . '/' . $folderToStore);
        $stub = $this->getStub('Action');

        $stubValues = [
            '{{ namespace }}',
            '{{ action_title }}',
            '{{ response_namespace }}',
            '{{ request_namespace }}',
        ];
        $values = [
            $this->generateNamespace('App/Http/' . $folderToStore),
            $this->title,
            $this->responseNamespace,
            $this->requestNamespace
        ];

        $actionContent = str_replace(
            $stubValues,
            $values,
            $stub
        );

        $this->writeFile(app_path() . "/Http" . '/' . $folderToStore . "/" . $this->title."Action" . '.php', $actionContent);
    }

    protected function createRequest()
    {
        $folderToStore = "Requests/".$this->path;
        $this->createFolder(app_path() . "/Http" . '/' . $folderToStore);
        $stub = $this->getStub('Request');

        $stubValues = [
            '{{ namespace }}',
            '{{ action_title }}',
        ];
        $this->requestNamespace = $this->generateNamespace('App/Http/' . $folderToStore);
        $values = [
            $this->requestNamespace,
            $this->title
        ];

        $actionContent = str_replace(
            $stubValues,
            $values,
            $stub
        );

        $this->writeFile(app_path() . "/Http" . '/' . $folderToStore . "/" . $this->title."Request" . '.php', $actionContent);
    }

    protected function createResponse()
    {
        $folderToStore = "Responses/".$this->path;
        $this->createFolder(app_path() . "/Http" . '/' . $folderToStore);
        $stub = $this->getStub('Response');

        $stubValues = [
            '{{ namespace }}',
            '{{ action_title }}',
        ];

        $this->responseNamespace = $this->generateNamespace('App/Http/' . $folderToStore);
        $values = [
            $this->responseNamespace,
            $this->title
        ];

        $actionContent = str_replace(
            $stubValues,
            $values,
            $stub
        );

        $this->writeFile(app_path() . "/Http" . '/' . $folderToStore . "/" . $this->title."Response" . '.php', $actionContent);
    }

    /**
     * @param string $namespace
     * @return string
     */
    public function generateNamespace(string $namespace): string
    {
        return preg_replace('|([\\\\]+)|s', '\\', ucwords(str_replace('/', '\\', $namespace), '\\'));
    }
}
