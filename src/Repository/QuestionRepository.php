<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

final class QuestionRepository
{
    public function __construct(
        private readonly PDO $pdo,
    ) {
    }

    /**
     * @param array{
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     club: string,
     *     club_function: ?string,
     *     department: string,
     *     department_function: ?string,
     *     region: string,
     *     region_function: ?string,
     *     question_1: string,
     *     question_2: ?string,
     *     question_3: ?string,
     *     created_at: string
     * } $data
     */
    public function create(array $data): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO questions (
                first_name,
                last_name,
                email,
                club,
                club_function,
                department,
                department_function,
                region,
                region_function,
                question_1,
                question_2,
                question_3,
                created_at
            ) VALUES (
                :first_name,
                :last_name,
                :email,
                :club,
                :club_function,
                :department,
                :department_function,
                :region,
                :region_function,
                :question_1,
                :question_2,
                :question_3,
                :created_at
            )'
        );

        $statement->execute($data);

        return (int) $this->pdo->lastInsertId();
    }
}