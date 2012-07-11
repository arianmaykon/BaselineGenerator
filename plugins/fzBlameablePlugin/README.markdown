fzBlameable
=================

While it is possible to use clean Doctrine extension blameable, it's possible
that you'll forget to add customized listener to every table that needs Blameable behaviour.
Goal of this plugin is to provide customized Blameable for symfony with back relation alias.
Apart from that change it's almost identical to the diem's modification to Blameable plugin.

Original behaviour could be found there:
[doctrine-project.org](http://www.doctrine-project.org/extension/Blameable)
before the change in doctrine-project.org website.
Modification applied to listener could be found [here.](http://botchedcode.com/2010/02/16/symfony-1-4-doctrine-extension-blameable-w-sfguard/)

Instalation:
------------

To install plugin from symfony plugin repository run:

    ./symfony plugin:install fzBlameablePlugin

To install plugin from package, copy it to your project root's directory and run:

    ./symfony plugin:install fzBlameablePlugin-1.1.0.tgz

After installing, you have to run:


Usage:
------------

To use this behaviour simply add fzBlameable to your model:

    MyModel:
      actAs:
        fzBlameable:

And then run:

    ./symfony doctrine:generate-migrations-diff
    ./symfony doctrine:migrate
    ./symfony doctrine:build --all-classes

After that you'll have two fields created_by and updated_by added to your model,
and two relations between your model, and sfGuardUser. By default, both created
and updated fields and relations will be enabled allowing null values.

These are default settings for columns fzBlameable, you don't have to write them unless you want to change them!

    MyModel:
      actAs:
        fzBlameable:
          columns:
            created:
              name: created_by
              alias: null
              type: integer
              length: 8
              disabled: false
              options:
                notnull: false
            updated:
              #same as for created here

Default values for created_by and updated_by are suited for sfDoctrineGuard 5.x

You can also modify relations:

    MyModel:
      actAs:
        fzBlameable:
          relations:
            created:
              disabled: false
              name: CreatedBy
              foreign: id
              foreignAlias: false
            updated:
              #same as for created here

###DQL Usage###

To use this relations in dql, you have as in original behaviour, CreatedBy relation
in the model with behaviour. Additionally fzBlameable adds Created*MyModel*s
relation alias to the sfGuardUser, which eases creation of complex dql queries.

The Created*MyModel*s is default name for relation alias on sfGuardUser model. 
To set own name, please modify foreignAlias setting for each relation


Thanks
------------

Thanks to:

*Colin DeCarlo, author of the original behaviour,
*Sean Villani, for information about modifying Blameable for sfGuardUser
