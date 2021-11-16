ALTER TABLE [dbo].[TBLPropinsi] ALTER COLUMN [KdPropinsi] char(2) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLPropinsi] ALTER COLUMN [NmPropinsi] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKabupaten] ALTER COLUMN [KdKabupaten] char(4) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKabupaten] ALTER COLUMN [KdPropinsi] char(2) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKabupaten] ALTER COLUMN [NmKabupaten] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKecamatan] ALTER COLUMN [KdKecamatan] char(7) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKecamatan] ALTER COLUMN [KdKabupaten] char(4) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKecamatan] ALTER COLUMN [NmKecamatan] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKelurahan] ALTER COLUMN [KdKelurahan] char(11) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKelurahan] ALTER COLUMN [KdKecamatan] char(7) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO

ALTER TABLE [dbo].[TBLKelurahan] ALTER COLUMN [NmKelurahan] nvarchar(255) COLLATE SQL_Latin1_General_CP1_CI_AS 
GO


