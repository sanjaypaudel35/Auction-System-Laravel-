<?php

namespace App\Core\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait Slugify
{
    protected string $slugField = "slug";

    /**
     * Slugify with current repository model.
     *
     * @param string $slugify
     * @param string $operator
     * @param string|null $startParenthesis
     * @param string|null $endParenthesis
     * @param array $additionalQuery
     *
     * @return string
     */
    public function slugify(
        string $slugify,
        string $operator = "-",
        ?string $startParenthesis = null,
        ?string $endParenthesis = null,
        array $additionalQuery = []
    ): string {
        try {
            $slug = Str::slug($slugify, $operator);
            $original_slug = $slug;

            $allSlugs = $this->getRelatedSlugs(
                slugify: $slug,
                operator: $operator,
                additionalQueries: $additionalQuery
            );
            if ($allSlugs->contains("{$this->slugField}", $slug)) {
                $count = $allSlugs->count();

                while ($this->checkIfSlugExist($slug, $additionalQuery)) {
                    if (
                        $startParenthesis
                        && $endParenthesis
                    ) {
                        $slug = "{$original_slug}{$startParenthesis}{$count}{$endParenthesis}";
                    } else {
                        $slug = "{$original_slug}{$operator}{$count}";
                    }
                    $count++;
                }
                $slug = "{$slug}";
            }
        } catch (Exception $exception) {
            throw $exception;
        }

        return $slug;
    }

    /**
     * Query related slug
     *
     * @param string $slugify
     * @param string|null $operator
     * @param string|null $startParenthesis
     * @param string|null $endParenthesis
     * @param array $additionalQueries
     *
     * @return object
     */
    private function getRelatedSlugs(
        string $slugify,
        ?string $operator = "-",
        ?string $startParenthesis = null,
        ?string $endParenthesis = null,
        array $additionalQueries = []
    ): object {
        try {
            if ($endParenthesis === "(") {
                $operator = '\\' . $startParenthesis;
                $endOperator = '\\' . $endParenthesis;
            } else {
                $operator = $operator;
                $endOperator = '';
            }
            $regex = '^' . $slugify . '(' . $operator . '[0-9]+' . $endOperator . ')?$';
            $rows = $this->model->whereRaw("{$this->slugField} RLIKE ?", [$regex]);
            if ($additionalQueries !== []) {
                $rows = $this->getDataWithRelation($additionalQueries, $rows);
            }
            $relatedSlugs = $rows->get();
        } catch (Exception $exception) {
            throw $exception;
        }

        return $relatedSlugs;
    }

    /**
     *
     * Check if slug exists.
     *
     * @param string $slugify
     * @param array $additionalQueries
     *
     * @return bool
     */
    private function checkIfSlugExist(string $slugify, array $additionalQueries = []): bool
    {
        try {
            $rows = $this->model::where($this->slugField, $slugify);
            if ($additionalQueries !== []) {
                $rows = $this->getDataWithRelation($additionalQueries, $rows);
            }
            $exists = $rows->exists();
        } catch (Exception $exception) {
            throw $exception;
        }

        return $exists;
    }

    /**
     * Get data with relation
     *
     * @param array $additionalQueries
     * @param Builder $rows
     *
     * @return object
     */
    public function getDataWithRelation(array $additionalQueries, Builder $rows): object
    {
        $formattedQueries = &$additionalQueries;
        foreach ($additionalQueries as $column => $additionalQuery) {
            $relationalQuery = explode(".", $column);
            $relationalKey = Arr::first($relationalQuery);
            $relationalColumn = Arr::last($relationalQuery);
            if (count($relationalQuery) === 2) {
                $rows = $rows->whereRelation($relationalKey, $relationalColumn, $additionalQuery);
                unset($formattedQueries[$column]);
            }
        }

        if (count($formattedQueries) > 0) {
            $rows = $rows->where($formattedQueries);
        }

        return $rows;
    }
}
