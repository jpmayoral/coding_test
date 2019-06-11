<?php

namespace Redstage\Banner\Api;

/**
 * @api
 */
interface BannerRepositoryInterface
{
    /**
     * Save banner
     *
     * @param \Redstage\Banner\Api\Data\BannerInterface $banner
     * @param bool $saveOptions
     * @return \Redstage\Banner\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\StateException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Redstage\Banner\Api\Data\BannerInterface $banner, $saveOptions = false);

    /**
     * Get info about banner by id
     *
     * @param string $id
     * @param bool $editMode
     * @param int|null $storeId
     * @param bool $forceReload
     * @return \Redstage\Banner\Api\Data\BannerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($id);

    /**
     * Delete banner
     *
     * @param \Redstage\Banner\Api\Data\BannerInterface $banner
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Redstage\Banner\Api\Data\BannerInterface $banner);

    /**
     * @param string $id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($id);

    /**
     * @param bool $forceReload
     * @return mixed
     */
    public function getAll($forceReload = false);
}