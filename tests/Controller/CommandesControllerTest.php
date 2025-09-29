<?php

namespace App\Test\Controller;

use App\Entity\Commandes;
use App\Repository\CommandesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommandesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CommandesRepository $repository;
    private string $path = '/commandes/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Commandes::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commande index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'commande[dateCommande]' => 'Testing',
            'commande[quantite]' => 'Testing',
            'commande[nonClient]' => 'Testing',
            'commande[nomProduit]' => 'Testing',
        ]);

        self::assertResponseRedirects('/commandes/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commandes();
        $fixture->setDateCommande('My Title');
        $fixture->setQuantite('My Title');
        $fixture->setNonClient('My Title');
        $fixture->setNomProduit('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Commande');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Commandes();
        $fixture->setDateCommande('My Title');
        $fixture->setQuantite('My Title');
        $fixture->setNonClient('My Title');
        $fixture->setNomProduit('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'commande[dateCommande]' => 'Something New',
            'commande[quantite]' => 'Something New',
            'commande[nonClient]' => 'Something New',
            'commande[nomProduit]' => 'Something New',
        ]);

        self::assertResponseRedirects('/commandes/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDateCommande());
        self::assertSame('Something New', $fixture[0]->getQuantite());
        self::assertSame('Something New', $fixture[0]->getNonClient());
        self::assertSame('Something New', $fixture[0]->getNomProduit());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Commandes();
        $fixture->setDateCommande('My Title');
        $fixture->setQuantite('My Title');
        $fixture->setNonClient('My Title');
        $fixture->setNomProduit('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/commandes/');
    }
}
