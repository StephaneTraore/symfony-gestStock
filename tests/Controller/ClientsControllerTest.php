<?php

namespace App\Test\Controller;

use App\Entity\Clients;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ClientsRepository $repository;
    private string $path = '/clients/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Clients::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client index');

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
            'client[nomClient]' => 'Testing',
            'client[prenomClient]' => 'Testing',
            'client[adresseClient]' => 'Testing',
            'client[Telephone]' => 'Testing',
            'client[EmailClient]' => 'Testing',
        ]);

        self::assertResponseRedirects('/clients/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Clients();
        $fixture->setNomClient('My Title');
        $fixture->setPrenomClient('My Title');
        $fixture->setAdresseClient('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setEmailClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Client');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Clients();
        $fixture->setNomClient('My Title');
        $fixture->setPrenomClient('My Title');
        $fixture->setAdresseClient('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setEmailClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'client[nomClient]' => 'Something New',
            'client[prenomClient]' => 'Something New',
            'client[adresseClient]' => 'Something New',
            'client[Telephone]' => 'Something New',
            'client[EmailClient]' => 'Something New',
        ]);

        self::assertResponseRedirects('/clients/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNomClient());
        self::assertSame('Something New', $fixture[0]->getPrenomClient());
        self::assertSame('Something New', $fixture[0]->getAdresseClient());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getEmailClient());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Clients();
        $fixture->setNomClient('My Title');
        $fixture->setPrenomClient('My Title');
        $fixture->setAdresseClient('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setEmailClient('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/clients/');
    }
}
