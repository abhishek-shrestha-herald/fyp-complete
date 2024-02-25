<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModelResolver
{
    protected string $modelClass;
    protected string $modelName;

    protected string $resolveKey;
    protected $resolveValue;

    protected array $with = [];
    protected bool $throwsException = true;

    public function __construct(
        string $modelClass,
        string $modelName,
    ) {
        $this->modelClass = $modelClass;
        $this->modelName = $modelName;

    }

    public function resolve(string $key, $value): ModelResolver
    {
        $this->resolveKey = $key;
        $this->resolveValue = $value;
        return $this;
    }

    public function with(array $with): ModelResolver
    {
        $this->with = $with;
        return $this;
    }

    public function withoutException(): ModelResolver
    {
        $this->throwsException = false;
        return $this;
    }

    public function get(): ?Model
    {
        $model = null;

        if (!class_exists($this->modelClass)) {
            return $this->handleException();
        }

        if (!is_a($this->modelClass, Model::class, true)) {
            return $this->handleException();
        }

        if (count($this->with) == 0) {
            $model = $this->modelClass::where($this->resolveKey, $this->resolveValue)
                ->first();
        } else {
            $model = $this->modelClass::with($this->with)
                ->where($this->resolveKey, $this->resolveValue)
                ->first();
        }

        if(is_null($model))
        {
            return $this->handleException();
        }

        return $model;
    }

    private function handleException()
    {
        if ($this->throwsException) {
            throw new ModelNotFoundException($this->modelName . ' where ' . $this->resolveKey . ': ' . $this->resolveValue . ' not found.');
        }
        return null;
    }
}
