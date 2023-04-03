<?php

namespace MsysCorp\TransportifyDeliveree\Validation;

use MsysCorp\TransportifyDeliveree\Exception\InvalidArgumentException;
use MsysCorp\TransportifyDeliveree\Lookups\TimeType;
use DateTime;
use MsysCorp\TransportifyDeliveree\Lookups\Paginate as LookUps;

class Paginate
{
    use Validation;

    protected ?int $page;
    protected ?int $perPage;
    protected ?string $fromDate;
    protected ?string $toDate;
    protected ?string $status;
    protected ?string $search;
    protected ?string $sortBy;
    protected ?string $orderBy;

    /**
     *
     */
    public function __construct(){}

    /**
     * @return array|null
     */
    public function getPage() : ?string
    {
        return $this->extraServices ?? null;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setPage(int $page) : Paginate
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getPerPage() : ?string
    {
        return $this->perPage ?? null;
    }

    /**
     * @param int $perPage
     * @return $this
     */
    public function setPerPage(int $perPage) : Paginate
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSearch() : ?string
    {
        return $this->search ?? null;
    }

    /**
     * @param string $search
     * @return $this
     */
    public function setSearch(string $search) : Paginate
    {
        $this->search = $search;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFromDate() : ?string
    {
        return $this->fromDate ?? null;
    }

    /**
     * @param string $fromDate
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setFromDate(string $fromDate) : Paginate
    {
        if (!is_null($fromDate) && !$this->validateDateTime($fromDate)) {
            throw new InvalidArgumentException();
        }
        $this->fromDate = $fromDate;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getToDate() : ?string
    {
        return $this->fromDate ?? null;
    }

    /**
     * @param string $toDate
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setToDate(string $toDate) : Paginate
    {
        if (!empty($toDate) && !$this->validateDateTime($toDate)) {
            throw new InvalidArgumentException();
        }
        $this->toDate = $toDate;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus() : ?string
    {
        return $this->status ?? null;
    }

    /**
     * @param string $status
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setStatus(string $status) : Paginate
    {
        if (!is_null($status) && !$this->validateDeliveryStatus($status)) {
            throw new InvalidArgumentException();
        }

        $this->status = $status;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSortBy() : ?string
    {
        return $this->sortBy ?? null;
    }

    /**
     * @param string $sortBy
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setSortBy(string $sortBy) : Paginate
    {
        if (!empty($sortBy) && !$this->validateSortBy($sortBy)) {
            throw new InvalidArgumentException();
        }
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOrderBy() : ?string
    {
        return $this->sortBy ?? null;
    }

    /**
     * @param string $OrderBy
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setOrderBy(string $OrderBy) : Paginate
    {
        if (!empty($OrderBy) && !$this->validateOrderBy($OrderBy)) {
            throw new InvalidArgumentException();
        }
        $this->sortBy = $OrderBy;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'page' => $this->getPage(),
            'per_page' => $this->getPerPage(),
            'from_date' => $this->getFromDate(),
            'to_date' => $this->getToDate(),
            'status' => $this->getStatus(),
            'search' => $this->getSearch(),
            'sort_by' => $this->getSortBy(),
            'order_by' => $this->getOrderBy() ?? LookUps::DESC,
        ]);
    }
}