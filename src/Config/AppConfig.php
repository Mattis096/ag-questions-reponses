<?php

declare(strict_types=1);

namespace App\Config;

final class AppConfig
{
    public function __construct(
        private readonly string $databasePath,
        private readonly string $eventName,
        private readonly string $eventStartDate,
        private readonly string $eventEndDate,
        private readonly string $eventCity,
        private readonly string $eventDepartment,
        private readonly string $questionDeadline,
    ) {
    }

    public function getDatabasePath(): string
    {
        return $this->databasePath;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function getEventStartDate(): string
    {
        return $this->eventStartDate;
    }

    public function getEventEndDate(): string
    {
        return $this->eventEndDate;
    }

    public function getEventCity(): string
    {
        return $this->eventCity;
    }

    public function getEventDepartment(): string
    {
        return $this->eventDepartment;
    }

    public function getQuestionDeadline(): string
    {
        return $this->questionDeadline;
    }

    public function formatDate(string $date): string
    {
        $dateTime = new \DateTimeImmutable($date);

        $days = [
            'Sunday' => 'dimanche',
            'Monday' => 'lundi',
            'Tuesday' => 'mardi',
            'Wednesday' => 'mercredi',
            'Thursday' => 'jeudi',
            'Friday' => 'vendredi',
            'Saturday' => 'samedi',
        ];

        $months = [
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre',
        ];

        return sprintf(
            '%s %d %s %d',
            $days[$dateTime->format('l')],
            (int) $dateTime->format('j'),
            $months[(int) $dateTime->format('n')],
            (int) $dateTime->format('Y'),
        );
    }

    public function formatEventDates(
        string $startDate,
        string $endDate,
    ): string {
        $start = new \DateTimeImmutable($startDate);
        $end = new \DateTimeImmutable($endDate);

        $months = [
            1 => 'janvier',
            2 => 'février',
            3 => 'mars',
            4 => 'avril',
            5 => 'mai',
            6 => 'juin',
            7 => 'juillet',
            8 => 'août',
            9 => 'septembre',
            10 => 'octobre',
            11 => 'novembre',
            12 => 'décembre',
        ];

        $startDay = (int) $start->format('j');
        $endDay = (int) $end->format('j');
        $startMonth = (int) $start->format('n');
        $endMonth = (int) $end->format('n');
        $startYear = $start->format('Y');
        $endYear = $end->format('Y');

        if ($startMonth === $endMonth && $startYear === $endYear) {
            return sprintf(
                '%d et %d %s %s',
                $startDay,
                $endDay,
                $months[$startMonth],
                $startYear,
            );
        }

        return sprintf(
            '%d %s %s et %d %s %s',
            $startDay,
            $months[$startMonth],
            $startYear,
            $endDay,
            $months[$endMonth],
            $endYear,
        );
    }

    public static function fromEnvironment(string $projectDirectory): self
    {
        $databasePath = $_ENV['DATABASE_PATH'] ?? 'var/database.sqlite';

        if (!str_starts_with($databasePath, '/')) {
            $databasePath = $projectDirectory . '/' . $databasePath;
        }

        return new self(
            $databasePath,
            $_ENV['AG_NAME'] ?? 'ASSEMBLÉE GÉNÉRALE',
            $_ENV['AG_START_DATE'] ?? '',
            $_ENV['AG_END_DATE'] ?? '',
            $_ENV['AG_CITY'] ?? '',
            $_ENV['AG_DEPARTMENT'] ?? '',
            $_ENV['AG_QUESTION_DEADLINE'] ?? '',
        );
    }
}