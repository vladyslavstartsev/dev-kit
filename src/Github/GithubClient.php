<?php

declare(strict_types=1);

/*
 * This file is part of the Sonata Project package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Github;

use Github\Client;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class GithubClient
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Adds a label from an issue if this one is not set.
     */
    public function addIssueLabel(string $repoUser, string $repoName, int $issueId, string $label): void
    {
        foreach ($this->client->issues()->labels()->all($repoUser, $repoName, $issueId) as $labelInfo) {
            if ($label === $labelInfo['name']) {
                return;
            }
        }

        $this->client->issues()->labels()->add($repoUser, $repoName, $issueId, $label);
    }

    /**
     * Removes a label from an issue if this one is set.
     */
    public function removeIssueLabel(string $repoUser, string $repoName, int $issueId, string $label): void
    {
        foreach ($this->client->issues()->labels()->all($repoUser, $repoName, $issueId) as $labelInfo) {
            if ($label === $labelInfo['name']) {
                $this->client->issues()->labels()->remove($repoUser, $repoName, $issueId, $label);

                break;
            }
        }
    }
}
